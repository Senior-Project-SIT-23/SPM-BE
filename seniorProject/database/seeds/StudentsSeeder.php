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
                'student_id' => '60130500038',
                'student_name' => 'Thanatcha',
                'student_email' => 'Thanatcha@st.sit.kmutt.ac.th',
                'department' => ''
            ],
            [
                'student_id' => '60130500082',
                'student_name' => 'Watunyu',
                'student_email' => '60130500082@st.sit.kmutt.ac.th',
                'department' => ''
            ],
            [
                'student_id' => '60130500114',
                'student_name' => 'Suthiwat',
                'student_email' => '60130500114@st.sit.kmutt.ac.th',
                'department' => ''
            ],
            [
                'student_id' => '60130500104',
                'student_name' => 'Ittidate',
                'student_email' => '60130500104@st.sit.kmutt.ac.th',
                'department' => ''
            ],
            [
                'student_id' => '60130500105',
                'student_name' => 'Intira',
                'student_email' => '60130500105@st.sit.kmutt.ac.th',
                'department' => ''
            ],
            [
                'student_id' => '60130500125',
                'student_name' => 'Thamrongchai',
                'student_email' => '60130500125@st.sit.kmutt.ac.th',
                'department' => ''
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
