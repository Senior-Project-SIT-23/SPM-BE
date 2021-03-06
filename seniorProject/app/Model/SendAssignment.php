<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SendAssignment extends Model
{
    protected $table = 'send_assignment';

    public function groups()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignments()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

}