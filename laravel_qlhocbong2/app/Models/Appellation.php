<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Appellation extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'appellations';
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    protected $guarded = [''];
}
