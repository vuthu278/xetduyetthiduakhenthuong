<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AppellationRegister extends Model
{
    use HasFactory;
    protected $table = 'appellations_register';
    protected $guarded = [''];

    const STATUS_DEFAULT = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_CANCEL = -1;
    const STATUS_DAT = 3;
    const STATUS_NOT_DAT = 4;

    protected $statusConfig = [
    0 => [
        'name' => 'Chờ xét duyệt',
        'class' => 'label-dark label bg-dark'
    ],
    self::STATUS_DEFAULT => [
        'name' => 'Đã xem',
        'class' => 'label-info label bg-info'
    ],
    self::STATUS_SUCCESS => [
        'name' => 'Được đề nghị xét duyệt',
        'class' => 'label-warning label bg-warning'
    ],
    self::STATUS_CANCEL => [
        'name' => 'Không được đề nghị xét duyệt',
        'class' => 'label-danger label bg-danger'
    ],
    self::STATUS_DAT => [
        'name' => 'Đạt danh hiệu',
        'class' => 'label-success label bg-success'
    ],
    self::STATUS_NOT_DAT => [
        'name' => 'Không đạt danh hiệu',
        'class' => 'label-primary label bg-primary'
    ],
];


    public function getStatus()
    {
        return Arr::get($this->statusConfig, $this->status, []);
    }

    public function appellation()
    {
        return $this->belongsTo(Appellation::class,'appellation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
