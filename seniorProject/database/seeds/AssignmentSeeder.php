<?php

use App\Model\Assignment;
use App\Model\ResponsibleAssignment;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignments = (array) array(
            [
                'assignment_id' => '1',
                'assignment_title' => 'Programing Clinic: Midterm',
                'assignment_detail' => 'งานของ Programming Clinic ที่จะส่งปลายภาคนักศึกษาสามารถศึกษาและดูตัวอย่างแผนภาพ Package Diagram ตามไฟล์ประกอบใน Assignment',
                'due_date' => '2020-6-5',
                'due_time' => '20:00',
                'date_time' => '2020-6-5 20:00',
                'teacher_id' => '1',
                'rubric_id' => '1'
            ],
            [
                'assignment_id' => '2',
                'assignment_title' => 'Midterm กรรมการสอบ',
                'assignment_detail' => 'กรรมการห้องสอบ (30 คะแนน) (กลางภาค 10 คะแนน / ปลายภาค 20 คะแนน) ภาพรวมของงาน 20 คะแนน (สัดส่วน 80% ของคะแนน) การนำเสนอ 10 คะแนน (สัดส่วน 10%), การตอบคำถาม 10 คะแนน (สัดส่วน 10%)',
                'due_date' => '2020-11-9',
                'due_time' => '20:00',
                'date_time' => '2020-11-9 20:00',
                'teacher_id' => '1',
                'rubric_id' => '2'
            ]
        );

        $responsible_assignments = (array) array(
            [
                'id' => '1',
                'assignment_id' => '1',
                'responsible_teacher_id' => '1'
            ],
            [
                'id' => '2',
                'assignment_id' => '2',
                'responsible_teacher_id' => '1'
            ],
            [
                'id' => '3',
                'assignment_id' => '2',
                'responsible_teacher_id' => '2'
            ]
        );

        foreach ($assignments as $assignment) {
            $temp_assignment = new Assignment;
            $temp_assignment->assignment_id = Arr::get($assignment, 'assignment_id');
            $temp_assignment->assignment_title = Arr::get($assignment, 'assignment_title');
            $temp_assignment->assignment_detail = Arr::get($assignment, 'assignment_detail');
            $temp_assignment->due_date = Arr::get($assignment, 'due_date');
            $temp_assignment->due_time = Arr::get($assignment, 'due_time');
            $temp_assignment->date_time = Arr::get($assignment, 'date_time');
            $temp_assignment->teacher_id = Arr::get($assignment, 'teacher_id');
            $temp_assignment->rubric_id = Arr::get($assignment, 'rubric_id');
            $temp_assignment->save();
        }
        foreach ($responsible_assignments as $responsible_assignment) {
            $temp_responsible_assignment = new ResponsibleAssignment;
            $temp_responsible_assignment->id = Arr::get($responsible_assignment, 'id');
            $temp_responsible_assignment->assignment_id = Arr::get($responsible_assignment, 'assignment_id');
            $temp_responsible_assignment->responsible_teacher_id = Arr::get($responsible_assignment, 'responsible_teacher_id');
            $temp_responsible_assignment->save();
        }
    }
}
