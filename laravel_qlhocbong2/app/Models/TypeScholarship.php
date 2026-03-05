<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class TypeScholarship extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'type_scholarship';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];
}
