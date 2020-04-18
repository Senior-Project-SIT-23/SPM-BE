<?php

namespace App\Repositories;

use App\Model\Group;
use App\Model\Project;
use App\Model\Student;
use App\Model\ProjectDetail;
use App\Model\Teacher;
use App\Model\ResponsibleTeacherGroup;
use App\Model\ResponsibleAAGroup;
use App\Model\AA;
use Illuminate\Support\Arr;



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
        $project->department = $data['department'];
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
    
        if(count($data['teacher_id'])>0){
            foreach ($data['teacher_id'] as $value) {    
                $reponsible_teacher_group = new ResponsibleTeacherGroup();
                $reponsible_teacher_group->teacher_id = $value;
                $reponsible_teacher_group->project_id = $project_id;
                $reponsible_teacher_group->save();
                $reponsible_aa_group = new ResponsibleAAGroup();
            }
        }
            $reponsible_aa_group = new ResponsibleAAGroup();
            $aa_id = AA::where('department', $data['department'])->first()->aa_id;
            $reponsible_aa_group->aa_id = $aa_id;
            $reponsible_aa_group->project_id = $project_id;
            $reponsible_aa_group->save();
        

    }

    public function updateProject($data)
    {
        foreach ($data['delete_student_id'] as $value) {
            Group::where('groups.project_id', $data['project_id'])->where('groups.student_id', "$value")->delete();
        }
        foreach ($data['delete_teacher_id'] as $value) {
            ResponsibleTeacherGroup::where('responsible_teacher_group.project_id', $data['project_id'])->where('responsible_teacher_group.teacher_id', "$value")->delete();
        }
        foreach ($data['add_student_id'] as $value) {
            if (!Group::where('project_id', $data['project_id'])->where('student_id', "$value")->first()) {
                Student::where('student_id', "$value")->update(['department' => $data['department']]);
                $group = new Group();
                $group->student_id = $value;
                $group->project_id = $data['project_id'];
                $group->group_id = $data['group_id'];
                $group->save();
            }
        }
        foreach ($data['add_teacher_id'] as $value) {
            if (!ResponsibleTeacherGroup::where('responsible_teacher_group.project_id', $data['project_id'])->where('responsible_teacher_group.teacher_id', "$value")->first()) {
                $responsible_teacher_group = new ResponsibleTeacherGroup();
                $responsible_teacher_group->teacher_id = $value;
                $responsible_teacher_group->project_id = $data['project_id'];
                $responsible_teacher_group->save();
            }
        }
        Project::where('project_id', $data['project_id'])->update(['project_name' => $data['project_name']]);
        ProjectDetail::where('project_id', $data['project_id'])->update(['project_detail' => $data['project_detail']]);
    }

    public function deleteProjectById($project_id)
    {
        $project = Project::where('project_id',$project_id)->delete();
        return $project;
    }


    public function getProjectById($project_id)
    {
        $group = Project::join('groups', 'groups.project_id', '=', 'projects.project_id')->where('projects.project_id', "$project_id")
            ->join('students', 'students.student_id', '=', 'groups.student_id')->where('groups.project_id', "$project_id")->get();

        $project = Project::join('project_detail', 'project_detail.project_id', '=', 'projects.project_id')
            ->where('project_detail.project_id', "$project_id")->first();

        $teacher = ResponsibleTeacherGroup::join('teachers','responsible_teacher_group.teacher_id','=','teachers.teacher_id')
            ->where('responsible_teacher_group.project_id',"$project_id")->get();

        $data = array("group"=>$group,"project"=>$project,"teacher"=>$teacher);
        return $data;
    }

    public function getProjectByTeacher($teacher_id){
        $responsible_teacher_group = Project::join('responsible_teacher_group','responsible_teacher_group.project_id','=','projects.project_id')
        ->where('responsible_teacher_group.teacher_id',"$teacher_id")->join('project_detail','project_detail.project_id','=','projects.project_id')
        ->where('responsible_teacher_group.teacher_id',"$teacher_id")
        ->get();

        return $responsible_teacher_group;
    }

    public function getProjectByAA($aa_id){
        $responsible_aa_group = Project::join('responsible_aa_group','responsible_aa_group.project_id','=','projects.project_id')
        ->where('responsible_aa_group.aa_id',"$aa_id")->join('project_detail','project_detail.project_id','=','projects.project_id')
        ->where('responsible_aa_group.aa_id',"$aa_id")
        ->get();

        return $responsible_aa_group;
    }

    public function getAllProject()
    {
        $projects = Project::all();
        foreach($projects as $key => $project){
            $teachers = ResponsibleTeacherGroup::join('teachers','teachers.teacher_id','=','responsible_teacher_group.teacher_id')
            ->where('responsible_teacher_group.project_id',"$project->project_id")->get();
            $projects[$key]->teachers = $teachers;
        }
        
        return $projects;
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
