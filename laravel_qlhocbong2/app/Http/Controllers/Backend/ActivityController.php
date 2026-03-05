<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityQrCode;
use App\Models\ActivityRegistration;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('department');

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->time_start) {
            $query->whereDate('time_start', '>=', $request->time_start);
        }
        if ($request->time_stop) {
            $query->whereDate('time_stop', '<=', $request->time_stop);
        }

        $activities = $query->orderByDesc('_id')->paginate(20);
        $departments = Department::all();

        $registrationCounts = [];
        $departmentNames = [];
        $activityIds = $activities->pluck('_id')->all();
        if (!empty($activityIds)) {
            $regCounts = ActivityRegistration::where('status', ActivityRegistration::STATUS_REGISTERED)
                ->whereIn('activity_id', $activityIds)
                ->get()
                ->groupBy(function ($r) {
                    return mongodb_id_string($r->activity_id);
                });
            foreach ($regCounts as $aid => $items) {
                $registrationCounts[$aid] = $items->count();
            }
        }
        foreach ($departments as $d) {
            $key = mongodb_id_string($d->_id);
            $name = $d->d_name ?? $d->name ?? $d->d_code ?? '-';
            $departmentNames[$key] = $name;
            if (is_numeric($d->_id)) {
                $departmentNames[(string) $d->_id] = $name;
            }
        }

        return view('backend.activity.index', compact('activities', 'departments', 'registrationCounts', 'departmentNames'));
    }

    public function create()
    {
        $activity = null;
        $departments = Department::all();
        return view('backend.activity.create', compact('activity', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $err = $this->validateActivityConflict($data['time_start'] ?? null, $data['time_stop'] ?? null, $data['location'] ?? '', null);
        if ($err) {
            return redirect()->back()->withInput($request->input())->with('error', $err);
        }
        $data['created_at'] = Carbon::now();
        $data['created_by'] = get_data_user('admins');
        Activity::create($data);
        session()->flash('success', 'Thêm hoạt động thành công!');
        return redirect()->route('backend.activity.index');
    }

    public function edit($id)
    {
        $activity = Activity::find($id);
        $departments = Department::all();
        return view('backend.activity.update', compact('activity', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $err = $this->validateActivityConflict($data['time_start'] ?? null, $data['time_stop'] ?? null, $data['location'] ?? '', $id);
        if ($err) {
            return redirect()->back()->withInput($request->input())->with('error', $err);
        }
        $data['updated_at'] = Carbon::now();
        Activity::find($id)->update($data);
        session()->flash('success', 'Cập nhật hoạt động thành công!');
        return redirect()->route('backend.activity.index');
    }

    public function delete($id)
    {
        $activity = Activity::find($id);
        if ($activity) $activity->delete();
        session()->flash('success', 'Xóa hoạt động thành công!');
        return redirect()->route('backend.activity.index');
    }

    /** Danh sách QR của hoạt động + tạo QR Vào / QR Ra */
    public function qrCodes($id)
    {
        $activity = Activity::with('qrCodes')->find($id);
        if (!$activity) return redirect()->route('backend.activity.index');
        $activityIdStr = (string) $activity->getRouteKey();
        return view('backend.activity.qr_codes', compact('activity', 'activityIdStr'));
    }

    /** Tạo mã QR (Vào hoặc Ra) có thời hạn */
    public function generateQr(Request $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) return redirect()->route('backend.activity.index');

        $validMinutes = (int) $request->get('valid_minutes', 5);
        $type = (int) $request->get('type', ActivityQrCode::TYPE_VAO);
        if (!in_array($type, [ActivityQrCode::TYPE_VAO, ActivityQrCode::TYPE_RA])) {
            $type = ActivityQrCode::TYPE_VAO;
        }

        $token = \Illuminate\Support\Str::random(32);
        $expiresAt = Carbon::now()->addMinutes($validMinutes);
        // Lưu dạng UTCDateTime để MongoDB hiển thị đúng, tránh lỗi 01/01/1970
        $expiresAtBson = new \MongoDB\BSON\UTCDateTime((int) ($expiresAt->getTimestamp() * 1000));
        $nowBson = new \MongoDB\BSON\UTCDateTime((int) (Carbon::now()->getTimestamp() * 1000));

        $qr = ActivityQrCode::create([
            'activity_id' => $activity->_id,
            'type' => $type,
            'token' => $token,
            'expires_at' => $expiresAtBson,
            'created_by' => get_data_user('admins'),
            'created_at' => $nowBson,
        ]);

        session()->flash('success', 'Đã tạo ' . ActivityQrCode::typeLabel($type) . '. Mã hết hạn lúc ' . $expiresAt->format('H:i d/m/Y'));
        return redirect()->route('backend.activity.qr_codes', ['id' => (string) $id]);
    }

    /** Kiểm tra trùng thời gian + địa điểm với hoạt động khác */
    protected function validateActivityConflict($timeStart, $timeStop, $location, $excludeId)
    {
        if (!$timeStart || !$timeStop) {
            return null;
        }
        $start = Carbon::parse($timeStart);
        $end = Carbon::parse($timeStop);
        $locNorm = trim(mb_strtolower((string) $location));

        $query = Activity::query();
        if ($excludeId) {
            $query->where('_id', '!=', $excludeId);
        }
        $others = $query->get();

        foreach ($others as $a) {
            $aLoc = trim(mb_strtolower((string) ($a->location ?? '')));
            if ($locNorm !== $aLoc) {
                continue;
            }
            $aStart = $a->time_start ? Carbon::parse($a->time_start) : null;
            $aEnd = $a->time_stop ? Carbon::parse($a->time_stop) : null;
            if (!$aStart || !$aEnd) {
                continue;
            }
            if ($start->lt($aEnd) && $aStart->lt($end)) {
                return 'Đã tồn tại hoạt động khác trùng thời gian và địa điểm: ' . ($a->name ?? 'Hoạt động') . '. Vui lòng chọn thời gian hoặc địa điểm khác.';
            }
        }
        return null;
    }

    /** Trang hiển thị QR để in / chiếu (admin) */
    public function showQr($id, $qrId)
    {
        $query = ActivityQrCode::with('activity')->where('activity_id', $id);
        if (is_numeric($qrId)) {
            $query->where('_id', (int) $qrId);
        } elseif (strlen((string) $qrId) === 24 && ctype_xdigit((string) $qrId) && class_exists(\MongoDB\BSON\ObjectId::class)) {
            try {
                $query->where('_id', new \MongoDB\BSON\ObjectId($qrId));
            } catch (\Exception $e) {
                $query->where('_id', $qrId);
            }
        } else {
            $query->where('_id', $qrId);
        }
        $qr = $query->first();
        if (!$qr) return redirect()->route('backend.activity.index');
        $scanUrl = route('user.scan') . '?token=' . $qr->token;
        $qrSvg = QrCode::format('svg')->size(280)->margin(1)->generate($scanUrl);
        $typeLabel = ActivityQrCode::typeLabel($qr->type);
        return view('backend.activity.show_qr', compact('qr', 'scanUrl', 'qrSvg', 'typeLabel'));
    }
}
