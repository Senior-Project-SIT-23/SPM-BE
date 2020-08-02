<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SendAssignment extends Model
{
    protected $table = 'send_assignments';

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignments()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}