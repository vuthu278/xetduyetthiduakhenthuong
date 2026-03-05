<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityAttendance;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityAttendance::with('user', 'activity');

        if ($request->activity_id) {
            $aid = is_array($request->activity_id) ? ($request->activity_id[0] ?? null) : $request->activity_id;
            if ($aid) {
                $query->where('activity_id', $aid);
            }
        }
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->type) {
            $query->where('scan_type', (int) $request->type);
        }
        if ($request->date_from) {
            $query->whereDate('scanned_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('scanned_at', '<=', $request->date_to);
        }

        $allAttendances = $query->orderByDesc('scanned_at')->get();

        // Gom nhóm theo sinh viên + hoạt động: mỗi SV 1 hàng, cột Vào và Ra cạnh nhau
        $grouped = [];
        foreach ($allAttendances as $att) {
            $uid = (string) mongodb_id_string($att->user_id ?? '');
            $aid = (string) mongodb_id_string($att->activity_id ?? '');
            $key = $uid . '|' . $aid;

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'user' => $att->user,
                    'activity' => $att->activity,
                    'check_in' => null,
                    'check_out' => null,
                ];
            }
            $type = (int) ($att->scan_type ?? 0);
            if ($type === 1) {
                if (!$grouped[$key]['check_in'] || ($att->scanned_at && (!$grouped[$key]['check_in']->scanned_at || $att->scanned_at < $grouped[$key]['check_in']->scanned_at))) {
                    $grouped[$key]['check_in'] = $att;
                }
            } elseif ($type === 2) {
                if (!$grouped[$key]['check_out'] || ($att->scanned_at && (!$grouped[$key]['check_out']->scanned_at || $att->scanned_at < $grouped[$key]['check_out']->scanned_at))) {
                    $grouped[$key]['check_out'] = $att;
                }
            }
        }

        $grouped = array_values($grouped);

        if ($request->type) {
            $t = (int) $request->type;
            $grouped = array_filter($grouped, function ($g) use ($t) {
                return ($t === 1 && $g['check_in']) || ($t === 2 && $g['check_out']);
            });
            $grouped = array_values($grouped);
        }

        usort($grouped, function ($a, $b) {
            $ta = $a['check_out'] ? $a['check_out']->scanned_at : ($a['check_in'] ? $a['check_in']->scanned_at : null);
            $tb = $b['check_out'] ? $b['check_out']->scanned_at : ($b['check_in'] ? $b['check_in']->scanned_at : null);
            if (!$ta) return 1;
            if (!$tb) return -1;
            return $tb <=> $ta;
        });

        $perPage = 50;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pageData = array_slice($grouped, ($currentPage - 1) * $perPage, $perPage);
        $queryParams = collect(request()->query())->map(function ($v) {
            return is_array($v) ? ($v[0] ?? null) : $v;
        })->filter()->all();
        $attendances = new LengthAwarePaginator(
            $pageData,
            count($grouped),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => $queryParams]
        );

        $activities = Activity::orderByDesc('_id')->get(['_id', 'name']);

        return view('backend.activity_attendance.index', compact('attendances', 'activities'));
    }
}
