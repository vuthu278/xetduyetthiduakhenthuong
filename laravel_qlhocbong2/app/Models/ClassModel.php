<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $guarded = [''];

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
