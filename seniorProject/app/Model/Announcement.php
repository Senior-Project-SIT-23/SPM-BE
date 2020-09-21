<?php

namespace App\Model;

use AnnouncementFile;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function aas()
    {
        return $this->belongsTo(AA::class, 'aa_id');
    }

    public function announcement_file()
    {
        return $this->hasMany(AnnouncementFile::class, 'announcement_id');
    }
}
