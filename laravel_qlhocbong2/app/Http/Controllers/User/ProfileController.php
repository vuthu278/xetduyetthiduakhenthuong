<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestChangePassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        //        dump(get_data_user('web','id'));
        //        dump(\Hash::check('123456', get_data_user('web','password')));
        //        if (\Hash::check('123456', get_data_user('web','password'))) {
        //            return  redirect()->route('user.password');
        //        }
    }

    public function index()
    {
        $user = User::find(get_data_user('web'));
        $user->load('department'); // Ép nạp quan hệ

        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $id = get_data_user('web');
        $data = $request->except('_token', 'password', 'avatar');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        if ($request->avatar) {
            $image = upload_image('avatar');
            if (isset($image['code'])) {
                $data['avatar'] = $image['name'];
            }
        }

        $data['updated_at'] = Carbon::now();
        User::find($id)->update($data);

        return redirect()->back();
    }

    public function password()
    {
        $user = User::find(get_data_user('web'));
        return view('user.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);



        $id = get_data_user('web');
        User::find($id)->update([
            'password' => bcrypt($request->password),
            'updated_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    public function changePassword()
    {
        $user = User::find(get_data_user('web'));
        return view('user.update_password', compact('user'));
    }

    public function updateChangePassword(RequestChangePassword $request)
    {
        $id = get_data_user('web');
        $data['password'] = bcrypt($request->password);
        $data['updated_at'] = Carbon::now();
        User::find($id)->update($data);
        return redirect()->route('user.index');
    }
}
