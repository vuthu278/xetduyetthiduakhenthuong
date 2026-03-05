<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appellation;
use App\Models\AppellationRegister;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;

class BackendController extends Controller
{
    public function index()
    {
        $level = get_data_user('admins', 'level'); // Lấy level của admin đăng nhập
        return view('backend.index', compact('level'));
    }

    public function dashboard()
    {
        $level = get_data_user('admins', 'level'); // 0 = admin cấp trường, != 0 = đơn vị
        $department_id = get_data_user('admins', 'department_id');

        // Thống kê chi tiết trạng thái đăng ký (MongoDB-compatible)
        $registerStatusQuery = AppellationRegister::when($level != 0, function ($query) use ($level) {
            $query->whereHas('user', function ($q) use ($level) {
                $q->where('department_id', $level);
            });
        });
        $statusCounts = [];
        foreach ([0, 1, 2, 3, -1, 4] as $s) {
            $statusCounts[$s] = (clone $registerStatusQuery)->where('status', $s)->count();
        }
        $statusLabels = [
            0 => 'Chờ xét duyệt',
            1 => 'Đã xem',
            2 => 'Được đề nghị xét duyệt',
            3 => 'Đạt danh hiệu',
            -1 => 'Không được đề nghị xét duyệt',
            4 => 'Không đạt danh hiệu',
        ];
        $register_status = collect($statusLabels)->mapWithKeys(fn ($label, $s) => [$label => $statusCounts[$s] ?? 0]);

        $statusQuery = AppellationRegister::when($level != 0, function ($query) use ($level) {
            $query->whereHas('user', function ($q) use ($level) {
                $q->where('department_id', $level);
            });
        });
        $status = collect([0, 1, 2, 3, -1, 4])->map(fn ($s) => (object)['totalStatus' => (clone $statusQuery)->where('status', $s)->count(), 'status' => $s])->filter(fn ($o) => $o->totalStatus > 0)->values();

        // Tổng số sinh viên theo khoa
        $total_student = User::where('type', 1)
            ->when($level != 0, function ($query) use ($level) {
                $query->where('department_id', $level);
            })
            ->count();

        $total_user = User::when($level != 0, function ($query) use ($level) {
            $query->where('department_id', $level);
        })->count();

        // Tổng số đăng ký danh hiệu theo khoa
        $total_register = AppellationRegister::when($level != 0, function ($query) use ($level) {
            $query->whereHas('user', function ($q) use ($level) {
                $q->where('department_id', $level);
            });
        })->count();

        $total_department = Department::count();
        $total_appellation = Appellation::count();

        // Lấy danh sách danh hiệu mới nhất
        $appellations = Appellation::orderByDesc('created_at')->get();

        // Lấy danh sách đăng ký mới nhất theo khoa
        $latest_registrations = AppellationRegister::with(['user', 'appellation'])
            ->when($level != 0, function ($query) use ($level) {
                $query->whereHas('user', function ($q) use ($level) {
                    $q->where('department_id', $level);
                });
            })
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'student_code' => $item->user->code ?? '',
                    'student_name' => $item->user->name ?? '',
                    'appellation_name' => $item->appellation->name ?? '',
                    'created_at' => $item->created_at,
                    'status' => $item->status,
                ];
            });

        // Thống kê đăng ký theo tháng theo khoa
        $register_by_month = [];
        for ($i = 1; $i <= 12; $i++) {
            $register_by_month[] = AppellationRegister::when($level != 0, function ($query) use ($level) {
                $query->whereHas('user', function ($q) use ($level) {
                    $q->where('department_id', $level);
                });
            })
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', date('Y'))
                ->count();
        }

        // Danh hiệu phổ biến (top 5) theo khoa (MongoDB aggregation)
        $popularBase = AppellationRegister::when($level != 0, function ($query) use ($level) {
            $query->whereHas('user', function ($q) use ($level) {
                $q->where('department_id', $level);
            });
        });
        $grouped = $popularBase->get()->groupBy('appellation_id')->map->count()->sortDesc()->take(5);
        $popular_appellations = $grouped->map(function ($total, $appId) {
            $app = Appellation::find($appId);
            return ['name' => $app->name ?? 'Không xác định', 'total' => $total];
        })->values()->all();

        // Lấy thông tin khoa hiện tại
        $current_department = null;
        if ($level != 0) {
            $current_department = Department::find($level);
        }
        // Lấy danh sách ứng viên mới nhất (ví dụ 5 người)
        $highlight_users = User::with('department')
            ->when($level != 0, function ($query) use ($level) {
                $query->where('department_id', $level);
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        //Lấy ds danh hiệu
        $latest_appellations = Appellation::orderByDesc('created_at')->take(5)->get();
        //Lấy danh sách xét duyệt danh hiệu
        $latest_reviews = AppellationRegister::with('appellation', 'user')
            ->when($level != 0, function ($query) use ($level) {
                $query->whereHas('user', function ($q) use ($level) {
                    $q->where('department_id', $level);
                });
            })
            ->orderByDesc('time_process')
            ->take(5)
            ->get();


        //Lấy ds phòng ban
        $latest_departments = Department::orderByDesc('created_at')->take(5)->get();

        $total_admins = Admin::count();
        $latest_admins = Admin::with('department')->orderByDesc('created_at')->take(5)->get();





        $viewData = [
            'level' => $level,
            'status'           => $status,
            'register_status'  => $register_status,
            'total_student'    => $total_student,
            'total_user'       => $total_user,
            'total_department' => $total_department,
            'total_appellation' => $total_appellation,
            'total_register'   => $total_register,
            'latest_registrations' => $latest_registrations,
            'appellations'     => $appellations,
            'register_by_month' => $register_by_month,
            'popular_appellations' => $popular_appellations,
            'current_department' => $current_department,
            'is_department_admin' => $level != 0,
            'highlight_users' => $highlight_users,
            'latest_appellations' => $latest_appellations,
            'latest_reviews' => $latest_reviews,
            'latest_departments' => $latest_departments,
            'total_admins' => $total_admins,
            'latest_admins' => $latest_admins,


        ];

        return view('backend.dashboard', $viewData);
    }
}
