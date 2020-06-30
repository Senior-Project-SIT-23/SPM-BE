<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResponsibleAssignment extends Model
{
    protected $table = 'responsible_assignment';

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function assignments()
    {
        return $this->belongsTo(Assignment::class,'assignment_id');
    }
}
