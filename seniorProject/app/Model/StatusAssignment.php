<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusAssignment extends Model
{
    protected $table = 'status_assignment';

    public function groups()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignments()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

}