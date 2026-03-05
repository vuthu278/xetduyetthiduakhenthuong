<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('department');

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->time_start) {
            $query->whereDate('time_start', '>=', $request->time_start);
        }
        if ($request->time_stop) {
            $query->whereDate('time_stop', '<=', $request->time_stop);
        }

        $activities = $query->orderByDesc('_id')->paginate(20);

        $registrations = [];
        $userId = get_data_user('web');
        $activityIds = $activities->pluck('_id')->all();

        if ($userId) {
            $regs = ActivityRegistration::where('user_id', $userId)
                ->whereIn('activity_id', $activityIds)
                ->get();
            foreach ($regs as $reg) {
                $registrations[mongodb_id_string($reg->activity_id)] = $reg;
            }
        }

        $registrationCounts = [];
        $departmentNames = [];
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

        $depts = \App\Models\Department::all();
        foreach ($depts as $d) {
            $key = mongodb_id_string($d->_id);
            $name = $d->d_name ?? $d->name ?? $d->d_code ?? '-';
            $departmentNames[$key] = $name;
            if (is_numeric($d->_id)) {
                $departmentNames[(string) $d->_id] = $name;
            }
        }

        return view('user.activity.index', compact('activities', 'registrations', 'registrationCounts', 'departmentNames'));
    }

    public function register($id)
    {
        $userId = get_data_user('web');
        if (!$userId) {
            return redirect()->route('user.activity.index')->with('error', 'Bạn cần đăng nhập để đăng ký hoạt động.');
        }

        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('user.activity.index')->with('error', 'Hoạt động không tồn tại.');
        }

        $startTime = $activity->time_start ? Carbon::parse($activity->time_start) : null;
        if ($startTime && Carbon::now()->greaterThanOrEqualTo($startTime)) {
            return redirect()->route('user.activity.index')->with('error', 'Đã quá thời gian đăng ký cho hoạt động này.');
        }

        $maxReg = (int) ($activity->max_registrations ?? 0);
        if ($maxReg > 0) {
            $currentCount = ActivityRegistration::where('activity_id', $activity->_id)
                ->where('status', ActivityRegistration::STATUS_REGISTERED)
                ->count();
            if ($currentCount >= $maxReg) {
                return redirect()->route('user.activity.index')->with('error', 'Hoạt động đã đủ số lượng đăng ký.');
            }
        }

        $newStart = $activity->time_start ? Carbon::parse($activity->time_start) : null;
        $newEnd = $activity->time_stop ? Carbon::parse($activity->time_stop) : null;
        if ($newStart && $newEnd) {
            $myRegs = ActivityRegistration::where('user_id', $userId)
                ->where('status', ActivityRegistration::STATUS_REGISTERED)
                ->where('activity_id', '!=', $activity->_id)
                ->get();
            foreach ($myRegs as $reg) {
                $other = Activity::find($reg->activity_id);
                if (!$other || !$other->time_start || !$other->time_stop) {
                    continue;
                }
                $oStart = Carbon::parse($other->time_start);
                $oEnd = Carbon::parse($other->time_stop);
                if ($newStart->lt($oEnd) && $oStart->lt($newEnd)) {
                    return redirect()->route('user.activity.index')->with('error', 'Hoạt động này trùng thời gian với hoạt động "' . ($other->name ?? '') . '" mà bạn đã đăng ký. Vui lòng hủy đăng ký hoạt động kia trước hoặc chọn hoạt động khác.');
                }
            }
        }

        ActivityRegistration::updateOrCreate(
            [
                'user_id' => $userId,
                'activity_id' => $activity->_id,
            ],
            [
                'status' => ActivityRegistration::STATUS_REGISTERED,
                'created_at' => Carbon::now(),
            ]
        );

        return redirect()->route('user.activity.index')->with('success', 'Đăng ký hoạt động thành công.');
    }

    public function cancel($id)
    {
        $userId = get_data_user('web');
        if (!$userId) {
            return redirect()->route('user.activity.index')->with('error', 'Bạn cần đăng nhập để hủy đăng ký.');
        }

        $activity = Activity::find($id);
        if (!$activity) {
            return redirect()->route('user.activity.index')->with('error', 'Hoạt động không tồn tại.');
        }

        $startTime = $activity->time_start ? Carbon::parse($activity->time_start) : null;
        // Cho phép hủy đăng ký đến trước giờ bắt đầu hoạt động.
        if ($startTime && Carbon::now()->greaterThanOrEqualTo($startTime)) {
            return redirect()->route('user.activity.index')->with('error', 'Đã quá thời gian hủy đăng ký cho hoạt động này.');
        }

        $reg = ActivityRegistration::where('user_id', $userId)
            ->where('activity_id', $activity->_id)
            ->first();

        if (!$reg || $reg->status !== ActivityRegistration::STATUS_REGISTERED) {
            return redirect()->route('user.activity.index')->with('error', 'Bạn chưa đăng ký hoạt động này.');
        }

        $reg->status = ActivityRegistration::STATUS_CANCELLED;
        $reg->updated_at = Carbon::now();
        $reg->save();

        return redirect()->route('user.activity.index')->with('success', 'Đã hủy đăng ký hoạt động.');
    }
}
