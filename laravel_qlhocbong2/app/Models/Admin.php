<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'admins';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    protected $guarded = [''];

    public function getRouteKey()
    {
        return (string) mongodb_id_string($this->getAttribute('_id'));
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'level', '_id');
    }
}
