<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'departments';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];
}
