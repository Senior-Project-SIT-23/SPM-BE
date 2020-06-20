<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criteria';

    public function rubric()
    {
        return $this->belongsTo(Rubric::class, 'rubric_id');
    }

    public function criteria_detail()
    {
        return $this->hasMany(CriteriaDetail::class, 'criteria_id');
    }
}
