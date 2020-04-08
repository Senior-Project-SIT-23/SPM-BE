<?php

namespace App\Repositories;

use App\Model\Group;
use App\Model\Project;
use App\Model\Student;
use App\Model\ProjectDetail;
use App\Model\Teacher;
use App\Model\ResponsibleGroup;
use App\Model\AA;


class UserManagementRepository implements UserManagementRepositoryInterface
{

    public function createProject($data)
    {
        foreach ($data['student_id'] as $value) {
            if (Group::where('student_id', "$value")->first()) {
                return "มีกลุ่มแล้ว $value";
            }
        }
        
        $count_project = Project::where('project_id', 'like', "$data[department]%");
        $project_id = $data['department'] . '01';
        if (count($count_project->get()) > 0) {
            $last_project_id = $count_project->orderby('project_id', 'desc')->first()->project_id;
            $project_id = substr($last_project_id, 2, 2);
            $project_id++;
            if ($project_id > 9) {
                $project_id = $data['department'] . $project_id;
            } else {
                $project_id = $data['department'] . '0' . $project_id;
            }
        }
        
        $project = new Project;
        $project->project_id = $project_id;
        $project->project_name = $data['project_name'];
        $project->save();

        $project_detail = new ProjectDetail;
        $project_detail->project_detail = $data['project_detail'];
        $project_detail->project_id = $project->project_id;
        $project_detail->save();


        $group_id = Group::orderBy('group_id', 'desc')->first();
        if (!$group_id) {
            $group_id = 1;
        } else {
            $group_id = $group_id->group_id;
            $group_id++;
        }

        foreach ($data['student_id'] as $value) {
            $student = Student::where('student_id', "$value")->update(['department' => $data['department']]);

            $group = new Group();
            $group->student_id = $value;
            $group->project_id = $project_id;
            $group->group_id = $group_id;
            $group->save();
        }
        $group_id = Group::where('project_id', $project_id)->first()->group_id;

        foreach ($data['teacher_id'] as $value) {
            $reponsible_group = new ResponsibleGroup();
            $reponsible_group->teacher_id = $value;
            $aa_id = AA::where('department', $data['department'])->first()->aa_id;
            $reponsible_group->aa_id = $aa_id;
            $reponsible_group->group_id = $group_id;
            $reponsible_group->save();
        }
    }

    public function updateProject($data)
    {
        foreach ($data['delete_student_id'] as $value) {
            Group::where('project_id', $data['project_id'])->where('student_id', "$value")->delete();
        }
        foreach ($data['delete_teacher_id'] as $value) {
            ResponsibleGroup::where('group_id', $data['group_id'])->where('teacher_id', "$value")->delete();
        }
        foreach ($data['student_id'] as $value) {
            if (!Group::where('project_id', $data['project_id'])->where('student_id', "$value")->first()) {
                Student::where('student_id', "$value")->update(['department' => $data['department']]);
                $group = new Group();
                $group->student_id = $value;
                $group->project_id = $data['project_id'];
                $group->group_id = $data['group_id'];
                $group->save();
            }
        }
        foreach ($data['teacher_id'] as $value) {
            if (!ResponsibleGroup::where('group_id', $data['group_id'])->where('teacher_id', "$value")->first()) {
                $reponsible_group = new ResponsibleGroup();
                $reponsible_group->teacher_id = $value;
                $reponsible_group->group_id = $data['group_id'];
                $aa_id = AA::where('department', $data['department'])->first()->aa_id;
                $reponsible_group->aa_id = $aa_id;
                $reponsible_group->save();
            }
        }
        Project::where('project_id', $data['project_id'])->update(['project_name' => $data['project_name']]);
        ProjectDetail::where('project_id', $data['project_id'])->update(['project_detail' => $data['project_detail']]);
    }

    public function getProjectById($project_id)
    {
        $project = Project::join('groups', 'groups.project_id', '=', 'projects.project_id')->where('projects.project_id', "$project_id")->get();
        return $project;
    }

    public function getAllStudent()
    {
        $students =  Student::all();
        return $students;
    }

    public function getAllTeacher()
    {
        $teachers =  Teacher::all();
        return $teachers;
    }
}
