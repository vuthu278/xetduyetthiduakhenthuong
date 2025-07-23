<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendLoginController extends Controller
{
    public function getLogin()
    {
        return view('backend.auth.login');
    }

    public function postLogin(Request $request)
    {
        if (\Auth::guard('admins')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('backend.index');
        }

        return redirect()
            ->back()
            ->with('error', 'Email hoặc mật khẩu không đúng!');
    }




    public function logout(Request $request)
    {
        \Auth::guard('admins')->logout();
        $request->session()->invalidate();
        return redirect()->back();
    }
}
