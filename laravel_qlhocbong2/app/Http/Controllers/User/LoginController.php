<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('user.auth.login');
    }

    public function postLogin(Request $request)
    {
        if (\Auth::guard('web')->attempt([
            'code' => $request->code,
            'password' => $request->password
        ])) {
            if ($request->password === '123456') {
                return redirect()->route('user.password');
            }
            return redirect()->route('user.index');
        }

        // THÊM THÔNG BÁO
        return redirect()->back()->with('error', 'Mã hoặc mật khẩu của bạn không đúng!');
    }


    public function logout(Request $request)
    {
        \Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->back();
    }
}
