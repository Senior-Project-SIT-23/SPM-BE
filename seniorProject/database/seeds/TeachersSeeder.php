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
                'teacher_id' => '1',
                'teacher_name' => 'Siam Yamsaengsung',
                'teacher_email' => 'siam@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '2',
                'teacher_name' => 'Umaporn Supasitthimethee',
                'teacher_email' => 'Umaporn@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '3',
                'teacher_name' => 'Tuul Triyason',
                'teacher_email' => 'Tuul@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '4',
                'teacher_name' => 'Sunisa Sathapornvajana',
                'teacher_email' => 'sunisa@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '5',
                'teacher_name' => 'Sanit Sirisawatvatana',
                'teacher_email' => 'sanit@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '6',
                'teacher_name' => 'Olarn Rojanapornpun',
                'teacher_email' => 'olarnr@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '7',
                'teacher_name' => 'Kittiphan Puapholthep',
                'teacher_email' => 'kittiphan@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '8',
                'teacher_name' => 'Montri Supattatham',
                'teacher_email' => 'montri@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '9',
                'teacher_name' => 'Pichet Limvachiranan',
                'teacher_email' => 'pichet@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '10',
                'teacher_name' => 'Kriengkrai Porkaew',
                'teacher_email' => 'porkaew@sit.kmutt.ac.th'
            ],
            [
                'teacher_id' => '11',
                'teacher_name' => 'Praisan Padungweang',
                'teacher_email' => 'praisan.pad@sit.kmutt.ac.th'
            ]
        );

        foreach($teachers as $teacher){
            $temp_teacher = new Teacher;
            $temp_teacher->teacher_id = Arr::get($teacher,'teacher_id');
            $temp_teacher->teacher_name = Arr::get($teacher,'teacher_name');
            $temp_teacher->teacher_email = Arr::get($teacher,'teacher_email');
            $temp_teacher->save();
        }

    }
}
