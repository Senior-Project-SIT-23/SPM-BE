<?php

use App\Model\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = (array) array(
            [
                'student_id' => '60130500082',
                'student_name' => 'Mr.WATUNYU PANMUN',
                'student_email' => '60130500082@st.sit.kmutt.ac.th',
                'department' => 'IT'
            ],
            [
                'student_id' => '60130500114',
                'student_name' => 'Mr.SUTHIWAT SIRITHANAKOM',
                'student_email' => '60130500114@st.sit.kmutt.ac.th',
                'department' => 'IT'
            ],
            [
                'student_id' => '60130500125',
                'student_name' => 'Mr.THAMRONGCHAI CHALOWAT',
                'student_email' => '60130500125@st.sit.kmutt.ac.th',
                'department' => 'IT'
            ],
        );

        foreach ($students as $student) {
            $temp_student = new Student;
            $temp_student->student_id = Arr::get($student, 'student_id');
            $temp_student->student_name = Arr::get($student, 'student_name');
            $temp_student->student_email = Arr::get($student, 'student_email');
            $temp_student->department = Arr::get($student, 'department');
            $temp_student->save();
        }
    }
}
