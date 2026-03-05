<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'class';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', '_id');
    }
}
