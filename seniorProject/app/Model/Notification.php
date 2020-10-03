<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function assignments()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function announcement()
    {
        return $this->belongsTo(Assignment::class, 'announcement_id');
    }

    public function student_notifications()
    {
        return $this->hasMany(StudentNotification::class, 'notification_id');
    }
}
