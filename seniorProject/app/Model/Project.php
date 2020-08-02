<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function groups()
    {
        return $this->belongsTo(Group::class,'project_id');
    }

    public function project_detail()
    {
        return $this->hasOne(ProjectDetail::class,'project_id');
    }

    public function responsible_teacher_group()
    {
        return $this->belongsTo(ResponsibleTeacherGroup::class, 'project_id');
    }

    public function responsible_aa_group()
    {
        return $this->belongsTo(ResponsibleAAGroup::class, 'project_id');
    }

    public function send_assignment()
    {
        return $this->hasMany(SendAssignment::class, 'project_id');
    }
}
