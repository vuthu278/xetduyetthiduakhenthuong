<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

require base_path("vendor/autoload.php");

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('backend.auth.admin-forgot-password');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->with('error', '⚠️ Email này không tồn tại trong hệ thống. Vui lòng kiểm tra lại!');
        }

        $otp = rand(100000, 999999); // Tạo mã OTP ngẫu nhiên 6 chữ số

        // Lưu OTP vào session với thời gian hết hạn
        Session::put('otp', $otp);
        Session::put('otp_email', $admin->email);
        Session::put('otp_expire', Carbon::now()->addMinutes(5)); // Hết hạn sau 5 phút

        try {
            // Kiểm tra cấu hình mail
            $mailConfig = [
                'host' => env('MAIL_HOST'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'encryption' => env('MAIL_ENCRYPTION'),
                'port' => env('MAIL_PORT'),
                'from_address' => env('MAIL_FROM_ADDRESS'),
                'from_name' => env('MAIL_FROM_NAME')
            ];

            // Log cấu hình mail (không log password)
            Log::info('Mail configuration:', array_merge(
                array_diff_key($mailConfig, ['password' => '']),
                ['password' => '******']
            ));

            // Kiểm tra các thông số cấu hình bắt buộc
            foreach ($mailConfig as $key => $value) {
                if (empty($value)) {
                    throw new \Exception("Mail configuration missing: {$key}");
                }
            }

            // Cấu hình SMTP
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->Debugoutput = function($str, $level) {
                Log::info("SMTP Debug: {$str}");
            };
            
            $mail->isSMTP();
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = $mailConfig['encryption'];
            $mail->Port = $mailConfig['port'];

            $mail->setFrom($mailConfig['from_address'], $mailConfig['from_name']);
            $mail->addAddress($admin->email);

            $mail->isHTML(true);
            $mail->Subject = 'Mã OTP đặt lại mật khẩu';
            $mail->Body    = "Mã OTP của bạn để đặt lại mật khẩu là: <strong>$otp</strong><br>
                              Mã OTP này sẽ hết hạn sau 5 phút.";

            $mail->send();
            Log::info('OTP đã gửi thành công đến email: ' . $admin->email);

            return redirect()->route('admin.verify.otp.form')->with('success', 'Mã OTP đã được gửi! Nhập OTP để xác thực.');
        } catch (Exception $e) {
            Log::error('Lỗi khi gửi OTP:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $admin->email
            ]);
            return back()->with('error', "⚠️ Không thể gửi mã OTP. Vui lòng thử lại sau hoặc liên hệ với quản trị viên.");
        }
    }

    public function showVerifyOTPForm()
    {
        return view('backend.auth.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Kiểm tra OTP hợp lệ
        if (
            Session::get('otp') == $request->otp &&
            Carbon::now()->lessThan(Session::get('otp_expire'))
        ) {
            // Xóa OTP sau khi xác nhận và điều hướng đến form đặt lại mật khẩu
            Session::forget('otp');
            return redirect()->route('admin.reset.password.form')->with('success', 'Xác thực OTP thành công! Hãy đặt lại mật khẩu.');
        }

        return back()->with('error', 'Mã OTP không hợp lệ hoặc đã hết hạn!');
    }
}
