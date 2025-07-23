<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::query();

        // Lọc theo mã khoa
        if ($request->filled('d_code')) {
            $departments->where('d_code', 'like', '%' . $request->d_code . '%');
        }

        // Lọc theo tên khoa
        if ($request->filled('d_name')) {
            $departments->where('d_name', 'like', '%' . $request->d_name . '%');
        }

        $departments = $departments->orderByDesc('id')->paginate(20);

        return view('backend.department.index', compact('departments'));
    }

    public function create()
    {
        return view('backend.department.create');
    }

    public function store(DepartmentRequest $request)
    {
        $request->validate([
            'd_code' => 'required|string|max:255',
            'd_name' => 'required|string|max:255',
        ], [
            'd_code.required' => '⚠️ Mã khoa không được để trống!',
            'd_name.required' => '⚠️ Tên khoa không được để trống!',
        ]);

        $data = $request->only(['d_code', 'd_name']);
        $data['created_at'] = Carbon::now();

        try {
            Department::create($data);
            return redirect()->route('backend.department.index')->with('success', 'Thêm mới thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi thêm mới! ' . $e->getMessage());
        }
    }




    public function edit($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return redirect()->route('backend.department.index')->with('error', 'Khoa không tồn tại!');
        }
        return view('backend.department.update', compact('department'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return redirect()->route('backend.department.index')->with('error', '⚠️ Không tìm thấy khoa này!');
        }

        $request->validate([
            'd_name' => 'required|string|max:255'
        ], [
            'd_name.required' => '⚠️ Bạn chưa nhập tên khoa!'
        ]);

        $data = $request->only(['d_code', 'd_name']);
        $data['updated_at'] = Carbon::now();

        $department->update($data);
        return redirect()->route('backend.department.index')->with('success', 'Cập nhật thành công!');
    }


    public function delete($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return redirect()->route('backend.department.index')->with('error', '⚠️ Không tìm thấy khoa này!');
        }

        $department->delete();
        return redirect()->route('backend.department.index')->with('success', 'Xóa thành công!');
    }
}
