<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $table = 'project_detail';

    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
