<?php

use App\Model\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = array(
            [
                'project_id' => 'IT01',
                'project_name' => 'spm',
                'department' => 'IT',
                'student_id' => ['60130500125', '60130500114', '60130500082'],
                'teacher_id' => ['1'],
                'project_detail' => 'Zompong'
            ]
        );

        foreach ($projects as $project) {
            $temp_project = new Project();
            $temp_project->project_id = Arr::get($project, 'project_id');
            $temp_project->project_name = Arr::get($project, 'project_name');
            $temp_project->project_department = Arr::get($project, 'department');
            $temp_project->student_id = Arr::get($project, 'student_id');
            $temp_project->teacher_id = Arr::get($project, 'teacher_id');
            $temp_project->project_detail = Arr::get($project, 'project_detail');
            $temp_project->save();
        }
    }
}
