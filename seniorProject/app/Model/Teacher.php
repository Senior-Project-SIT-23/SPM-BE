<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    public function reponsible_group()
    {
        return $this->hasMany(ResponsibleGroup::class,'teacher_id');
    }
}