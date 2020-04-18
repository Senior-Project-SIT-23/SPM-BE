<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AA extends Model
{
    protected $table = 'aa';

    public function reponsible_aa_group()
    {
        return $this->hasMany(ResponsibleAAGroup::class,'aa_id');
    }
}
