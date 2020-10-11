<?php

namespace App\Repositories;

use App\Model\Student;
use App\Model\Teacher;
use App\Model\AA;



class LoginRepository implements LoginRepositoryInterface
{
    public function createUser($data)
    {
        if ($data['user_type'] == 'st_group') {
            $student = Student::where('student_id', $data['user_id'])->first();
            if ($student) {
                Student::where('student_id', $data['user_id'])
                    ->update(['student_name' => $data['name_en'], 'student_email' => $data['email']]);
            } else {
                $student = new Student;
                $student->student_id = $data['user_id'];
                $student->student_name = $data['name_en'];
                $student->student_email = $data['email'];
                $student->save();
            }
        } else if ($data['user_type'] == 'inst_group') {
            $teacher = Teacher::where('teacher_id', $data['user_id'])->first();
            if ($teacher) {
                Teacher::where('teacher_id', $data['user_id'])
                    ->update(['teacher_name' => $data['name_en'], 'teacher_email' => $data['email']]);
            } else {
                $teacher = new Teacher;
                $teacher->teacher_id = $data['user_id'];
                $teacher->teacher_name = $data['name_en'];
                $teacher->teacher_email = $data['email'];
                $teacher->save();
            }
        } else if ($data['user_type'] == 'staff_group') {
            $aa = AA::where('aa_id', $data['user_id'])->first();
            if ($aa) {
                AA::where('aa_id', $data['user_id'])
                    ->update(['aa_name' => $data['name_en'], 'aa_email' => $data['email']]);
            } else {
                $aa = new AA;
                $aa->aa_id = $data['user_id'];
                $aa->aa_name = $data['name_en'];
                $aa->aa_email = $data['email'];
                $aa->save();
            }
        }
    }
}
