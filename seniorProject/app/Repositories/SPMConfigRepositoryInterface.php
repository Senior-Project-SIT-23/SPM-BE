<?php

namespace App\Repositories;

interface SPMConfigRepositoryInterface
{
    public function createConfig($data);
    public function getConfig();
    public function getConfigByYear($year_of_study);

    public function getStudentNotification($student_id);
    public function readStudentNotification($data);
    public function getTeacherNotification($teacher_id);
    public function readTeacherNotification($data);
    public function getAANotification($aa_id);
    public function readAANotification($data);
}
