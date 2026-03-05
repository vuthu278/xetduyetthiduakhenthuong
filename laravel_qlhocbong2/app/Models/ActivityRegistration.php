<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Đăng ký tham gia hoạt động của sinh viên.
 */
class ActivityRegistration extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'activity_registrations';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $guarded = [''];

    const STATUS_REGISTERED = 'registered';
    const STATUS_CANCELLED = 'cancelled';

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}

