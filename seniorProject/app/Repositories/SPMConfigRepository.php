<?php

namespace App\Repositories;

use App\Model\Notification;
use App\Model\SPMConfig;
use App\Model\Student;
use App\Model\StudentNotification;

class SPMConfigRepository implements SPMConfigRepositoryInterface
{

    public function createConfig($data)
    {
        $has_config = SPMConfig::where('year_of_study', $data['year_of_study'])->first();
        if (!$has_config) {
            $spm_config = new SPMConfig();
            $spm_config->year_of_study = $data['year_of_study'];
            $spm_config->number_of_member_min = $data['number_of_member_min'];
            $spm_config->number_of_member_max = $data['number_of_member_max'];
            $spm_config->student_one_more_group = $data['student_one_more_group'];
            $spm_config->save();
        } else {
            SPMConfig::where('year_of_study', $data['year_of_study'])->update(['number_of_member_min' => $data['number_of_member_min']]);
            SPMConfig::where('year_of_study', $data['year_of_study'])->update(['number_of_member_max' => $data['number_of_member_max']]);
            SPMConfig::where('year_of_study', $data['year_of_study'])->update(['student_one_more_group' => $data['student_one_more_group']]);
        }
    }

    public function getConfig()
    {
        $spm_config = SPMConfig::all();
        return $spm_config;
    }

    public function getConfigByYear($year_of_study)
    {
        $spm_config = SPMConfig::where('year_of_study', "$year_of_study")->first();
        return $spm_config;
    }


    //Notification
    public function getNotification($student_id)
    {
        $student = Student::where('student_id', $student_id)->first();

        $notification = Notification::all();

        $student_notification = StudentNotification::where('student_id', $student_id)->get();

        $num_of_unread = count($notification) - count($student_notification);

        

        $student->num_of_unread_notification = $num_of_unread;
        $student->all_notification = $notification;
        $student->read_notification = $student_notification;
        // $student->test = $test;

        return $student;
    }

    public function readNotification($data)
    {
        foreach ($data['notification_id'] as $value) {
            $student_notification = new StudentNotification;
            $student_notification->notification_id = $value;
            $student_notification->student_id = $data['student_id'];
            $student_notification->save();
        }
    }
}
