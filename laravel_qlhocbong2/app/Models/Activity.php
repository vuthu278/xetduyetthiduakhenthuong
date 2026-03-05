<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'activities';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $guarded = [''];

    /** Đảm bảo route/URL luôn nhận string, tránh preg_match array. */
    public function getRouteKey()
    {
        return (string) mongodb_id_string($this->getAttribute('_id'));
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }

    public function qrCodes()
    {
        return $this->hasMany(ActivityQrCode::class, 'activity_id', '_id');
    }

    public function attendances()
    {
        return $this->hasMany(ActivityAttendance::class, 'activity_id', '_id');
    }

    public function registrations()
    {
        return $this->hasMany(ActivityRegistration::class, 'activity_id', '_id');
    }
}
