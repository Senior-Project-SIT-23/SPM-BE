<?php

namespace App\Repositories;

interface SPMConfigRepositoryInterface
{
    public function createConfig($data);
    public function getConfig();
    public function getConfigByYear($year_of_study);

    public function getNotification($student_id);
    public function readNotification($data);
}
