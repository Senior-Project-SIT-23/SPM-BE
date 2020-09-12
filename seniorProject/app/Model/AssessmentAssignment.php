<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssessmentAssignment extends Model
{
    protected $table = 'assessment_assignment';

    public function reponsible_assignment()
    {
        return $this->belongsTo(ResponsibleAssignment::class,'reponsible_assignment_id');
    }
}
