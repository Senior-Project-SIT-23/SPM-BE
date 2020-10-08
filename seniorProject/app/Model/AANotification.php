<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AANotification extends Model
{
    protected $table = 'aa_notifications';

    public function notifications()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function aa()
    {
        return $this->belongsTo(aa::class, 'aa_id');
    }
}
