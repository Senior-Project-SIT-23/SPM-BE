<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    public function assignments()
    {
        return $this->belongsTo(Assignment::class,'assignment_id');
    }

    //appointment
}
