<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResponsibleTeacherGroup extends Model
{
    protected $table = 'responsible_teacher_group';

    public function teachers()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'project_id');
    }

}
