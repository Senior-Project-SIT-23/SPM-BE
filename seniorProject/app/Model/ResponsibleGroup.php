<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResponsibleGroup extends Model
{
    protected $table = 'responsible_group';

    public function aa()
    {
        return $this->belongsTo(AA::class, 'aa_id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'project_id');
    }

}
