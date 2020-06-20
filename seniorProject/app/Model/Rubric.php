<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $table = 'rubric';

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'assigmnet_id');
    }

    public function criteria()
    {
        return $this->hasMany(Criteria::class,'rubric_id');
    }

    //appointment
}
