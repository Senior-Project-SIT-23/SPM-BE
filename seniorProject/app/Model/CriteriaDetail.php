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
    
    public function criteria_score()
    {
        return $this->hasMany(CriteriaScore::class, 'criteria_Detail_id');
    }
}
