<?php

namespace App\Models;

use App\Models\Concerns\NormalizesMongoDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ActivityQrCode extends Model
{
    use HasFactory, NormalizesMongoDates;

    protected $connection = 'mongodb';
    protected $table = 'activity_qr_codes';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $guarded = [''];

    /** Đảm bảo route/URL luôn nhận string. */
    public function getRouteKey()
    {
        return (string) mongodb_id_string($this->getAttribute('_id'));
    }

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    const TYPE_VAO = 1;  // QR Vào (check-in)
    const TYPE_RA = 2;   // QR Ra (check-out)

    public static function typeLabel($type)
    {
        return $type == self::TYPE_VAO ? 'QR Vào' : 'QR Ra';
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', '_id');
    }

    public function attendances()
    {
        return $this->hasMany(ActivityAttendance::class, 'qr_code_id', '_id');
    }
}
