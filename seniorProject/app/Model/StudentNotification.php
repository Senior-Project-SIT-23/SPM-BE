<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentNotification extends Model
{
    protected $table = 'student_notifications';

    public function notifications()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}