<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeacherNotification extends Model
{
    protected $table = 'teacher_notifications';

    public function notifications()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
