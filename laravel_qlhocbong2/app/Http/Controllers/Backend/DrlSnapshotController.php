<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityAttendance;
use App\Models\ActivityQrCode;
use App\Models\DrlSnapshot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Chốt điểm DRL: tính toán từ ActivityAttendance và lưu vào DrlSnapshot (read-optimized).
 * Sinh viên xem DRL chỉ đọc DrlSnapshot.
 */
class DrlSnapshotController extends Controller
{
    public function index(Request $request)
    {
        $query = DrlSnapshot::with('user:id,name,code,department_id');

        if ($request->semester_key) {
            $query->where('semester_key', $request->semester_key);
        }
        if ($request->keyword) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('code', 'like', '%' . $request->keyword . '%');
            });
        }

        $snapshots = $query->orderByDesc('finalized_at')->paginate(20);
        $semesterKeys = DrlSnapshot::distinct()->pluck('semester_key')->filter()->values();

        return view('backend.drl_snapshot.index', compact('snapshots', 'semesterKeys'));
    }

    /**
     * Form chốt điểm: chọn học kỳ (semester_key) và khoảng thời gian hoạt động để tổng hợp.
     */
    public function create()
    {
        $activities = Activity::orderByDesc('_id')->get(['_id', 'name', 'time_start', 'time_stop']);
        return view('backend.drl_snapshot.create', compact('activities'));
    }

    /**
     * Thực hiện chốt: tính toán tham gia từ activity_attendances, tạo/cập nhật drl_snapshots.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester_key' => 'required|string|max:50',
            'activity_ids' => 'required|array',
            'activity_ids.*' => 'string',
        ]);

        $semesterKey = $request->semester_key;
        $activityIds = array_map(function ($id) {
            return is_string($id) ? $id : (string) $id;
        }, $request->activity_ids);
        $activities = Activity::whereIn('_id', $activityIds)->get()->keyBy(function ($a) {
            return (string) mongodb_id_string($a->_id);
        });

        $userData = []; // user_id => [ activities => [ activity_id => [...] ], total_points ]

        $registrations = \App\Models\ActivityRegistration::whereIn('activity_id', $activityIds)
            ->where('status', \App\Models\ActivityRegistration::STATUS_REGISTERED)
            ->get();
        $regMap = [];
        foreach ($registrations as $reg) {
            $ruid = $reg->user_id;
            $raid = (string) mongodb_id_string($reg->activity_id);
            if (!isset($regMap[$ruid])) $regMap[$ruid] = [];
            $regMap[$ruid][$raid] = true;
        }

        $activityIdsNorm = [];
        foreach ($activityIds as $id) {
            $activityIdsNorm[(string) mongodb_id_string($id)] = true;
        }

        $allAttendances = ActivityAttendance::orderBy('scanned_at')->get();
        foreach ($allAttendances as $att) {
            $attAid = (string) mongodb_id_string($att->activity_id);
            if (!isset($activityIdsNorm[$attAid])) {
                continue;
            }
            $uid = $att->user_id;
            if (!isset($userData[$uid])) {
                $userData[$uid] = ['activities' => [], 'total_points' => 0];
            }
            $slotKey = $attAid;
            if (!isset($userData[$uid]['activities'][$slotKey])) {
                $userData[$uid]['activities'][$slotKey] = [
                    'check_in_at' => null,
                    'check_out_at' => null,
                    'registered' => isset($regMap[$uid][$slotKey]),
                    'status' => 'none',
                    'points' => 0,
                ];
            }
            $type = (int) ($att->scan_type ?? (optional($att->qrCode)->type ?? 0));
            if ($type == ActivityQrCode::TYPE_VAO) {
                $userData[$uid]['activities'][$slotKey]['check_in_at'] = $att->scanned_at;
            } elseif ($type == ActivityQrCode::TYPE_RA) {
                $userData[$uid]['activities'][$slotKey]['check_out_at'] = $att->scanned_at;
            }
        }

        // Thêm các sinh viên đã đăng ký nhưng không có bản ghi điểm danh.
        foreach ($registrations as $reg) {
            $uid = $reg->user_id;
            $raid = (string) mongodb_id_string($reg->activity_id);
            if (!isset($userData[$uid])) {
                $userData[$uid] = ['activities' => [], 'total_points' => 0];
            }
            if (!isset($userData[$uid]['activities'][$raid])) {
                $userData[$uid]['activities'][$raid] = [
                    'check_in_at' => null,
                    'check_out_at' => null,
                    'registered' => true,
                    'status' => 'none',
                    'points' => 0,
                ];
            }
        }

        foreach ($userData as $userId => $data) {
            $details = [];
            $totalPoints = 0;
            foreach ($data['activities'] as $actId => $row) {
                $act = $activities->get($actId);
                $name = $act ? $act->name : 'Hoạt động #' . $actId;
                $pointsPerActivity = (float) ($act->points_per_activity ?? 2);
                $hasIn = !empty($row['check_in_at']);
                $hasOut = !empty($row['check_out_at']);
                $registered = !empty($row['registered']);
                $note = '';
                $pointsAdded = 0;
                $pointsDeducted = 0;

                if ($registered) {
                    if ($hasIn && $hasOut) {
                        $status = 'full';
                        $pointsAdded = $pointsPerActivity;
                        $note = 'Đã đăng ký và tham gia đầy đủ.';
                    } elseif ($hasIn || $hasOut) {
                        $status = 'partial';
                        $pointsAdded = $pointsPerActivity * 0.5;
                        $note = 'Đã đăng ký nhưng chỉ tham gia một phần thời gian.';
                    } else {
                        $status = 'none';
                        $note = 'Đăng ký nhưng không tham gia.';
                    }
                } else {
                    if ($hasIn || $hasOut) {
                        $status = 'partial';
                        $pointsAdded = $pointsPerActivity * 0.5;
                        $note = 'Tham gia nhưng không đăng ký trước - chỉ được điểm một phần.';
                    } else {
                        $status = 'none';
                    }
                }
                $points = $pointsAdded - $pointsDeducted;
                $totalPoints += $points;
                $details[] = [
                    'activity_id' => $actId,
                    'activity_name' => $name,
                    'status' => $status,
                    'points_added' => $pointsAdded,
                    'points_deducted' => $pointsDeducted,
                    'points' => $points,
                    'check_in_at' => $row['check_in_at'],
                    'check_out_at' => $row['check_out_at'],
                    'note' => $note,
                ];
            }

            DrlSnapshot::updateOrCreate(
                [
                    'user_id' => $userId,
                    'semester_key' => $semesterKey,
                ],
                [
                    'total_points' => $totalPoints,
                    'details' => $details,
                    'finalized_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        session()->flash('success', 'Đã chốt điểm DRL cho học kỳ "' . $semesterKey . '".');
        return redirect()->route('backend.drl_snapshot.index');
    }

    /**
     * Xem chi tiết bảng điểm của sinh viên.
     */
    public function show($id)
    {
        $snapshot = DrlSnapshot::with('user')->find($id);
        if (!$snapshot) {
            return redirect()->route('backend.drl_snapshot.index')->with('error', 'Không tìm thấy bản ghi.');
        }
        return view('backend.drl_snapshot.show', compact('snapshot'));
    }
}
