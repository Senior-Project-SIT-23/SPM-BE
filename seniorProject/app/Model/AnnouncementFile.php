<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnnouncementFile extends Model
{
    protected $table = 'announcement_file';

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }

   
}
