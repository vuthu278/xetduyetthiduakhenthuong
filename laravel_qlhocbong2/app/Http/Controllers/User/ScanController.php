<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityAttendance;
use App\Models\ActivityQrCode;
use App\Models\ActivityRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Sinh viên mở URL từ QR (token trong query).
 * GET: hiển thị trang quét (nếu chưa đăng nhập yêu cầu đăng nhập).
 * POST: ghi nhận điểm danh (ai quét, quét lúc nào, mã loại gì, mã do ai tạo).
 */
class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckLoginUser')->only('submit');
    }

    /** Trang quét QR: mở URL ?token=xxx (từ QR). Nếu đã đăng nhập có thể tự động ghi nhận hoặc hiển thị nút xác nhận. */
    public function index(Request $request)
    {
        $token = $request->get('token');
        if (!$token) {
            return redirect()->route('user.activity.index')
                ->with('error', 'Mã QR không hợp lệ.');
        }

        $qr = ActivityQrCode::with('activity')->where('token', $token)->first();
        if (!$qr) {
            return redirect()->route('user.activity.index')
                ->with('error', 'Mã QR không tồn tại.');
        }

        if (Carbon::parse($qr->expires_at)->isPast()) {
            return redirect()->route('user.activity.index')
                ->with('error', 'Mã QR đã hết hạn.');
        }

        $typeLabel = ActivityQrCode::typeLabel($qr->type);
        $user = auth()->guard('web')->user();
        $alreadyScanned = false;
        $hasRegistered = false;
        if ($user) {
            $alreadyScanned = ActivityAttendance::where('user_id', $user->_id)
                ->where('qr_code_id', $qr->_id)
                ->exists();
            $hasRegistered = ActivityRegistration::where('user_id', $user->_id)
                ->where('activity_id', $qr->activity_id)
                ->where('status', ActivityRegistration::STATUS_REGISTERED)
                ->exists();
        }

        return view('user.scan.index', [
            'qr' => $qr,
            'typeLabel' => $typeLabel,
            'alreadyScanned' => $alreadyScanned,
            'hasRegistered' => $hasRegistered,
        ]);
    }

    /** Ghi nhận điểm danh (POST từ trang quét). */
    public function submit(Request $request)
    {
        $token = $request->get('token');
        if (!$token) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => 'Thiếu mã QR.'], 400);
            return redirect()->route('user.activity.index')->with('error', 'Thiếu mã QR.');
        }

        $qr = ActivityQrCode::with('activity')->where('token', $token)->first();
        if (!$qr) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => 'Mã QR không tồn tại.'], 404);
            return redirect()->route('user.activity.index')->with('error', 'Mã QR không tồn tại.');
        }

        if (Carbon::parse($qr->expires_at)->isPast()) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => 'Mã QR đã hết hạn.'], 400);
            return redirect()->route('user.activity.index')->with('error', 'Mã QR đã hết hạn.');
        }

        $userId = get_data_user('web');
        $hasRegistered = ActivityRegistration::where('user_id', $userId)
            ->where('activity_id', $qr->activity_id)
            ->where('status', ActivityRegistration::STATUS_REGISTERED)
            ->exists();
        if (!$hasRegistered) {
            $msg = 'Vui lòng đăng ký hoạt động trước khi quét mã điểm danh.';
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => $msg], 403);
            return redirect()->route('user.activity.index')->with('error', $msg);
        }

        $existing = ActivityAttendance::where('user_id', $userId)->where('qr_code_id', $qr->_id)->first();
        if ($existing) {
            if ($request->wantsJson()) return response()->json(['success' => true, 'message' => 'Bạn đã điểm danh trước đó.', 'already' => true]);
            return redirect()->route('user.activity.index')->with('success', 'Bạn đã điểm danh trước đó.');
        }

        $scannedAt = Carbon::now();
        $clientTime = $request->input('scanned_at');
        if ($clientTime) {
            try {
                $parsed = Carbon::parse($clientTime);
                $now = Carbon::now();
                if ($parsed->between($now->copy()->subMinutes(10), $now->copy()->addMinutes(2))) {
                    $scannedAt = $parsed;
                }
            } catch (\Exception $e) {
                // Giữ Carbon::now() nếu parse lỗi
            }
        }

        ActivityAttendance::create([
            'user_id' => $userId,
            'activity_id' => $qr->activity_id,
            'qr_code_id' => $qr->_id,
            'scan_type' => $qr->type,
            'scanned_at' => $scannedAt,
            'created_by_admin' => $qr->created_by,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Điểm danh thành công!']);
        }
        return redirect()->route('user.activity.index')->with('success', 'Điểm danh thành công!');
    }
}
