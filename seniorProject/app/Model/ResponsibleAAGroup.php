<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResponsibleAAGroup extends Model
{
    protected $table = 'responsible_aa_group';

    public function aa()
    {
        return $this->belongsTo(AA::class,'aa_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'project_id');
    }

}
