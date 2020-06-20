<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function projects()
    {
        return $this->hasOne(Project::class,'project_id');
    }
}
