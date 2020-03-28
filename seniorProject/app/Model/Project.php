<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function groups()
    {
        return $this->hasMany(Group::class, 'project_id');
    }

    public function project_detail()
    {
        return $this->hasOne(ProjectDetail::class,'project_id');
    }
}
