<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public function groups()
    {
        return $this->belongsTo(Group::class,'student_id');
    }
}
