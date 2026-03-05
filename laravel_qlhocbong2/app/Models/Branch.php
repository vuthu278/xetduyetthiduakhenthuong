<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'branchs';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }
}
