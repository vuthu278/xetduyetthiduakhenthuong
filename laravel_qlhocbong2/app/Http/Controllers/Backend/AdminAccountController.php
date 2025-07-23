<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAccountRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::query();

        // Lọc theo tên tài khoản
        if ($request->filled('name')) {
            $admins->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo số điện thoại
        if ($request->filled('phone')) {
            $admins->where('phone', 'like', '%' . $request->phone . '%');
        }

        // Lọc theo email
        if ($request->filled('email')) {
            $admins->where('email', 'like', '%' . $request->email . '%');
        }

        // Lọc theo cấp quản trị
        if ($request->filled('level')) {
            if ($request->level == 0) {
                $admins->where('level', 0); // Admin trường
            } else {
                $admins->where('level', '!=', 0); // Admin khoa
            }
        }

        $admins = $admins->orderByDesc('id')->paginate(20);

        return view('backend.account.index', compact('admins'));
    }


    public function create()
    {
        $departments = Department::all();
        return view('backend.account.create', compact('departments'));
    }

    public function store(AdminAccountRequest $request)
    {
        $data               = $request->except('_token');
        $data['password']   = bcrypt($request->password);
        $data['created_at'] = Carbon::now();
        $user               = Admin::create($data);
        return redirect()->route('backend.account.index')->with('success', 'Tạo thành công');
    }

    public function edit($id)
    {
        $admin       = Admin::find($id);
        $departments = Department::all();
        $viewData    = [
            'admin'       => $admin,
            'departments' => $departments
        ];

        return view('backend.account.update', $viewData);
    }

    public function update(AdminAccountRequest $request, $id)
    {
        $data = $request->except('_token', 'password');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        $data['updated_at'] = Carbon::now();
        Admin::find($id)->update($data);

        return redirect()->route('backend.account.index')->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $user = Admin::find($id);
        if ($user) $user->delete();
        return redirect()->route('backend.account.index')->with('success', 'Xóa thành công');
    }
}
