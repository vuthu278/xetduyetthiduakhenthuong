<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Dữ liệu điểm rèn luyện đã chốt (read-optimized).
 * Khi sinh viên xem DRL, hệ thống chỉ truy vấn collection này, không tính toán.
 */
class DrlSnapshot extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'drl_snapshots';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $guarded = [''];

    public function getRouteKey()
    {
        return (string) mongodb_id_string($this->getAttribute('_id'));
    }

    protected $casts = [
        'details' => 'array', // [{ activity_id, activity_name, status, points, check_in_at, check_out_at }, ...]
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}
