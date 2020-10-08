<?php

namespace App\Repositories;

use App\Model\AA;
use App\Model\AANotification;
use App\Model\Notification;
use App\Model\SPMConfig;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\StudentNotification;
use App\Model\TeacherNotification;
use PhpParser\ErrorHandler\Collecting;

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
    public function getStudentNotification($student_id)
    {
        $student = Student::where('student_id', $student_id)->first();

        $notification = Notification::leftJoin('student_notifications', 'student_notifications.notification_id_fk', '=', 'notifications.notification_id')->get();

        $student_notification = StudentNotification::where('student_id', $student_id)->get();

        $num_of_unread = count($notification) - count($student_notification);

        $student->num_of_unread_notification = $num_of_unread;
        $student->notification = $notification;

        return $student;
    }

    public function readStudentNotification($data)
    {
        foreach ($data['notification_id'] as $value) {
            $check_notification = StudentNotification::where('student_id', $data['student_id'])
                ->where('notification_id_fk', $value)->first();
            if (!$check_notification) {
                $student_notification = new StudentNotification;
                $student_notification->notification_id_fk = $value;
                $student_notification->student_id = $data['student_id'];
                $student_notification->save();
            }
        }
    }

    public function getTeacherNotification($teacher_id)
    {
        $teacher = Teacher::where('teacher_id', $teacher_id)->first();

        $notification = Notification::leftJoin('teacher_notifications', 'teacher_notifications.notification_id_fk', '=', 'notifications.notification_id')->get();

        $teacher_notification = TeacherNotification::where('teacher_id', $teacher_id)->get();

        $num_of_unread = count($notification) - count($teacher_notification);

        $teacher->num_of_unread_notification = $num_of_unread;
        $teacher->notification = $notification;

        return $teacher;
    }

    public function readTeacherNotification($data)
    {
        foreach ($data['notification_id'] as $value) {
            $check_notification = TeacherNotification::where('teacher_id', $data['teacher_id'])
                ->where('notification_id_fk', $value)->first();
            if (!$check_notification) {
                $teacher_notification = new TeacherNotification;
                $teacher_notification->notification_id_fk = $value;
                $teacher_notification->teacher_id = $data['teacher_id'];
                $teacher_notification->save();
            }
        }
    }

    public function getAANotification($aa_id)
    {
        $aa = AA::where('aa_id', $aa_id)->first();

        $notification = Notification::leftJoin('aa_notifications', 'aa_notifications.notification_id_fk', '=', 'notifications.notification_id')->get();

        $aa_notification = AANotification::where('aa_id', $aa_id)->get();

        $num_of_unread = count($notification) - count($aa_notification);

        $aa->num_of_unread_notification = $num_of_unread;
        $aa->notification = $notification;

        return $aa;
    }

    public function readAANotification($data)
    {
        foreach ($data['notification_id'] as $value) {
            $check_notification = AANotification::where('aa_id', $data['aa_id'])
                ->where('notification_id_fk', $value)->first();
            if (!$check_notification) {
                $aa_notification = new AANotification;
                $aa_notification->notification_id_fk = $value;
                $aa_notification->aa_id = $data['aa_id'];
                $aa_notification->save();
            }
        }
    }
}
