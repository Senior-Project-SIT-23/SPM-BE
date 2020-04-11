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

    public function responsible_group()
    {
        return $this->belongsTo(ResponsibleGroup::class, 'group_id');
    }

}
