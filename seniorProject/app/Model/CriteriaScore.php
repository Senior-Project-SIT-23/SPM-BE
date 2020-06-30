<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CriteriaScore extends Model
{
    protected $table = 'criteria_detail';

    public function criteria_detail()
    {
        return $this->belongsTo(CriteriaDetail::class,'criteria_detail_id');
    }
    
}
