<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('department:id,d_name');

        if ($request->department_id)
            $users->where('department_id', $request->department_id);

        if ($request->type)
            $users->where('type', $request->type);

        $level = get_data_user('admins','level');

        if ($level != 0)
        {
            $users->where('department_id',$level);
        }

        if ($request->name)
            $users->where('name','like','%'.$request->name.'%');

        if ($request->code)
            $users->where('code','like','%'.$request->code.'%');

        $users =  $users->orderByDesc('id')
            ->paginate(20);

        $departments = Department::all();

        $viewData = [
            'users'       => $users,
            'departments' => $departments
        ];

        return view('backend.user.index', $viewData);
    }

    public function create()
    {
        $departments = Department::all();
        return view('backend.user.create', compact('departments'));
    }

    public function store(UserRequest $request)
    {
        $data               = $request->except('_token');
        $data['password']   = bcrypt('123456');
        $data['created_at'] = Carbon::now();
        $user               = User::create($data);
        return redirect()->route('backend.user.index')->with('success', 'Tạo thành công');
    }

    public function edit($id)
    {
        $departments = Department::all();
        $user        = User::find($id);
        $level = get_data_user('admins', 'level');


        $viewData = [
            'user'        => $user,
            'departments' => $departments
        ];

        return view('backend.user.update', $viewData);
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->except('_token', 'password');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        $data['updated_at'] = Carbon::now();
        User::find($id)->update($data);

        return redirect()->route('backend.user.index')->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) $user->delete();
        return redirect()->route('backend.user.index')->with('success', 'Xóa thành công');
    }
}
