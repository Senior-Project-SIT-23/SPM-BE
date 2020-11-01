<?php

use App\Model\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = (array) array(
            [
                'teacher_id' => 'testins01',
                'teacher_name' => 'Testins01 AtSIT',
                'teacher_email' => 'testins01@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => 'testins02',
                'teacher_name' => 'Testins02 AtSIT',
                'teacher_email' => 'testins02@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => 'testins03',
                'teacher_name' => 'Testins03 AtSIT',
                'teacher_email' => 'testins03@sit.kmutt.ac.th'
            ]
        );

        foreach ($teachers as $teacher) {
            $temp_teacher = new Teacher;
            $temp_teacher->teacher_id = Arr::get($teacher, 'teacher_id');
            $temp_teacher->teacher_name = Arr::get($teacher, 'teacher_name');
            $temp_teacher->teacher_email = Arr::get($teacher, 'teacher_email');
            $temp_teacher->save();
        }
    }
}
