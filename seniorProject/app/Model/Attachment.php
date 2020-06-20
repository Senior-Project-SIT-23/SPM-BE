<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    public function assignments()
    {
        return $this->belongsTo(Assignment::class,'assignment_id');
    }
}
