<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'users_roles';

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id');

    }
}
