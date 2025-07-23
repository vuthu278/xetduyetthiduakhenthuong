<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branchs';
    protected $guarded = [''];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
}
