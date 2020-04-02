<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AA extends Model
{
    protected $table = 'aa';

    public function reponsible_group()
    {
        return $this->hasMany(ResponsibleGroup::class,'aa_id');
    }
}
