<?php

namespace App\Model;

use AnnouncementFile;
use Illuminate\Database\Eloquent\Model;

class AA extends Model
{
    protected $table = 'aa';

    public function reponsible_aa_group()
    {
        return $this->hasMany(ResponsibleAAGroup::class, 'aa_id');
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'aa_id');
    }

    public function aa_notifications()
    {
        return $this->hasMany(AANotification::class, 'aa_id');
    }
}
