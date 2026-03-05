<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DrlSnapshot;
use Illuminate\Http\Request;

/**
 * Sinh viên xem điểm rèn luyện.
 * Chỉ đọc dữ liệu đã chốt (DrlSnapshot), không tính toán.
 */
class DrlController extends Controller
{
    public function index(Request $request)
    {
        $userId = get_data_user('web');
        $query = DrlSnapshot::where('user_id', $userId);

        if ($request->semester_key) {
            $query->where('semester_key', $request->semester_key);
        }

        $snapshots = $query->orderByDesc('finalized_at')->paginate(10);
        $semesterKeys = DrlSnapshot::where('user_id', $userId)->distinct()->pluck('semester_key')->filter()->values();

        return view('user.drl.index', compact('snapshots', 'semesterKeys'));
    }

    /** Chi tiết một kỳ DRL */
    public function show($id)
    {
        $userId = get_data_user('web');
        $snapshot = DrlSnapshot::where('user_id', $userId)->where('_id', (int) $id)->first();
        if (!$snapshot) {
            return redirect()->route('user.drl.index')->with('error', 'Không tìm thấy bản ghi.');
        }
        return view('user.drl.show', compact('snapshot'));
    }
}
