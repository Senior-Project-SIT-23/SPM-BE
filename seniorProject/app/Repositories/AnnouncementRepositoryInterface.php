<?php

namespace App\Repositories;

interface AnnouncementRepositoryInterface
{
    public function createAnnouncement($data);
    public function addAttachment($data);
    public function getAllAnnouncement();
    public function getAnnouncement($announcement_id);
    public function editAnnoucement($data);
    public function deleteAnnoucement($data);
}

