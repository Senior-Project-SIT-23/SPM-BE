<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    public function reponsible_teacher_group()
    {
        return $this->hasMany(ResponsibleTeacherGroup::class,'teacher_id');
    }

    public function reponsible_assignment()
    {
        return $this->hasMany(ResponsibleAssignment::class,'teacher_id');
    }
}
