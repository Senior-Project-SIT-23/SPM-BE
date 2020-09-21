<?php

namespace App\Repositories;

use App\Model\Announcement;
use App\Model\AnnouncementFile;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    public function createAnnouncement($data)
    {
        $announcement = new Announcement;
        $announcement->announcement_title = $data['announcement_title'];
        $announcement->announcement_detail = $data['announcement_detail'];

        if ($data['teacher_id']) {
            $announcement->teacher_id = $data['teacher_id'];
        } else if ($data['aa_id']) {
            $announcement->aa_id = $data['aa_id'];
        }

        $announcement->save();
    }

    public function addAttachment($data)
    {
        $announcement = Announcement::where('announcement.announcement_title', $data['announcement_title'])
            ->where('announcement.announcement_detail', $data['announcement_detail'])->first();
        $announcement_id = $announcement->announcement_id;
        foreach ($data['attachment'] as $values) {
            if ($values) {
                $temp = $values->getClientOriginalName();
                $temp_name = pathinfo($temp, PATHINFO_FILENAME);
                $extension = pathinfo($temp, PATHINFO_EXTENSION);
                $custom_file_name = $temp_name . "_" . $this->incrementalHash() . ".$extension";
                $path = $values->storeAs('/announcement', $custom_file_name);
                $announcement = new AnnouncementFile;
                $announcement->announcement_file = $path;
                $announcement->announcement_file_name = $temp;
                $announcement->keep_file_name = $custom_file_name;
                $announcement->announcement_id = $announcement_id;
                $announcement->save();
            }
        }
    }

    public function editAnnoucement($data)
    {
        Announcement::where('announcement_id', $data['announcement_id'])
            ->update([
                'announcement_title' => $data['announcement_title'],
                'announcement_detail' => $data['announcement_detail']
            ]);
        foreach ($data['delete_attachment'] as $values) {
            if ($values) {
                $announcement_file = AnnouncementFile::where('announcement_file_id', $values)->first();
                $keep_file_name = $announcement_file->keep_file_name;
                AnnouncementFile::where('announcement_file_id', $values)->delete();
                unlink(storage_path('app/announcement/' . $keep_file_name));
            }
        }
    }

    public function deleteAnnoucement($data)
    {
        $announcement = AnnouncementFile::where('announcement_id', $data['announcement_id'])->get();

        foreach ($announcement as $values) {
            $keep_file_name = $values->keep_file_name;
            unlink(storage_path('app/announcement/' . $keep_file_name));
        }

        Announcement::where('announcement_id', $data['announcement_id'])->delete();
        AnnouncementFile::where('announcement_id', $data['announcement_id'])->delete();
    }

    public function getAllAnnouncement()
    {
        $announcement = Announcement::all();
        return $announcement;
    }

    public function getAnnouncement($announcement_id)
    {
        $announcement = Announcement::where('announcement_id', $announcement_id)->first();
        $announcement_file = AnnouncementFile::where('announcement_id', $announcement_id)->get();

        $announcement->attachment = $announcement_file;
        return $announcement;
    }


    public function incrementalHash($len = 5)
    {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base) {
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -5);
    }
}
