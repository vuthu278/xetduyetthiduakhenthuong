<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appellation;
use Illuminate\Http\Request;

class AppellationController extends Controller
{
    public function index(Request $request)
    {
        $type = get_data_user('web', 'type');
        $query = Appellation::where('type', $type);

        // Tìm kiếm theo tên danh hiệu
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo ngày bắt đầu và ngày kết thúc (giống Admin)
        if ($request->time_start && $request->time_stop) {
            $query->whereDate('time_start', $request->time_start)
                ->whereDate('time_stop', $request->time_stop);
        } elseif ($request->time_start) {
            $query->whereDate('time_start', $request->time_start);
        } elseif ($request->time_stop) {
            $query->whereDate('time_stop', $request->time_stop);
        }

        $appellations = $query->orderByDesc('id')->paginate(20);

        return view('user.appellation.index', compact('appellations'));
    }
}
