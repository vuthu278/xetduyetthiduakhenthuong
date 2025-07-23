<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    public function showForm()
    {
        return view('backend.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => '⚠️ Mật khẩu mới không khớp! Vui lòng thử lại.'
        ]);

        // Lấy email từ session
        $email = Session::get('otp_email');
        if (!$email) {
            return back()->with('error', '⚠️ Không tìm thấy email, vui lòng thử lại!');
        }

        // Kiểm tra email có tồn tại không
        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return back()->with('error', '⚠️ Email không tồn tại! Vui lòng nhập đúng email.');
        }

        // Cập nhật mật khẩu mới
        $admin->password = Hash::make($request->password);
        $admin->save();

        // Xóa OTP sau khi đặt lại mật khẩu thành công
        Session::forget('otp_email');

        return redirect()->route('get_admin.login')->with('success', 'Đổi mật khẩu thành công! Hãy đăng nhập.');
    }
}
