<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Projects;

class Group extends Model
{
    protected $table = 'groups';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projects()
    {
        return $this->belongsTo(Projects::class,'project_id');
    }
}
