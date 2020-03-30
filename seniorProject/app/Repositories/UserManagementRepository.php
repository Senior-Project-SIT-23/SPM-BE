<?php

namespace App\Repositories;

use App\Model\Group;
use App\Model\Project;
use App\Model\User;
use App\Model\UserRole;
use App\Model\ProjectDetail;

class UserManagementRepository implements UserManagementRepositoryInterface
{
    public function createProject($data)
    {
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

        foreach ($data["user_id"] as $value) {
            $group = new Group;
            $group->user_id = $value;
            $group->project_id = $project->project_id;
            $group->save();
        }

        // foreach ($data['user_id'] as $value) {
        //     // $user = new User;
        //     // $user->user_id = $value['user_id'];
        //     // $user->user_name = $value['user_name'];
        //     // $user->department = $data['department'];
        //     // $user_role = new UserRole;
        //     // $user_role->role_id = 1;
        //     // $user_role->user_id = $value['user_id'];
        //     // $user->save();
        //     // $group = new Group;
        //     // $group->user_id = $value['user_id'];
        //     // $group->project_id = $project->project_id;
        //     // $group->save();
        //     // $user_role->save();
        // }

        // foreach ($data['advisor'] as $value) {
        //     $user = new User;
        //     $user->user_id = $value['user_id'];
        //     $user->user_name = $value['user_name'];
        //     $user->department = $data['department'];
        //     $user_role = new UserRole;
        //     $user_role->role_id = 2;
        //     $user_role->user_id = $value['user_id'];
        //     $user->save();
        //     $group = new Group;
        //     $group->user_id = $value['user_id'];
        //     $group->project_id = $project->project_id;
        //     $group->save();
        //     $user_role->save();
        // }
    }

    // public function getStudent()
    // {
    //     $student = User::get('user_id',)
    // }

    public function getAllUser()
    {
        $users = User::with('users_roles');
        dd($users);
        return $users;
    }
}
