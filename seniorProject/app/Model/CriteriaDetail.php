<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CriteriaDetail extends Model
{
    protected $table = 'criteria_detail';

    public function criteria()
    {
        return $this->belongsTo(Criteria::class,'criteria_id');
    }
    
    //criteria_score
}
