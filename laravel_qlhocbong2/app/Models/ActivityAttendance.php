<?php

namespace App\Models;

use App\Models\Concerns\NormalizesMongoDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Ghi nhận mỗi lần sinh viên quét QR (Vào hoặc Ra).
 * Hệ thống chỉ lưu: ai quét, quét lúc nào, quét mã loại gì, mã do ai tạo.
 */
class ActivityAttendance extends Model
{
    use HasFactory, NormalizesMongoDates;

    protected $connection = 'mongodb';
    protected $table = 'activity_attendances';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];
    protected $casts = ['scanned_at' => 'datetime'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', '_id');
    }

    public function qrCode()
    {
        return $this->belongsTo(ActivityQrCode::class, 'qr_code_id', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}
