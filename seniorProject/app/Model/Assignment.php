<?php

namespace App\Model;

use Attachments;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';

    public function rubric()
    {
        return $this->belongsTo(Rubric::class, 'assignment_id');
    }

    public function responsible_assignment()
    {
        return $this->hasMany(ResponsibleAssignment::class, 'assignment_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'assignment_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class,'assignment_id');
    }
    
    //individual_score
}
