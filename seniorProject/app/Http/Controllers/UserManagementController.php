<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserManagementRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class UserManagementController extends Controller
{

    private $userManagement;

    public function __construct(UserManagementRepositoryInterface $userManagement)

    {
        $this->userManagement = $userManagement;
    }

    public function storeProject(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'project_name' => 'required',
            'department' => 'required',
            'student_id' => 'required',
            'project_detail' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        //
        $data = $request->all();
        $result = $this->userManagement->createProject($data);
        if ($result) {
            return response()->json($result, 500);
        }
        return response()->json('สำเร็จ', 200);
    }

    public function editProject(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'project_id' => 'required',
            'group_id' => 'required',
            'department' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        //
        $data = $request->all();
        $this->userManagement->updateProject($data);
        return response()->json('สำเร็จ', 200);
    }

    public function deleteProject(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $validator =  Validator::make($request->all(), [
            'project_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $project_id = $request->all()['project_id'];
        $project = $this->userManagement->deleteProjectById($project_id);

        return response()->json('สำเร็จ', 200);
    }

    public function indexStudent()
    {
        $students = $this->userManagement->getAllStudent();
        return response()->json($students, 200);
    }

    public function indexTeacher()
    {
        $teachers = $this->userManagement->getAllTeacher();
        return response()->json($teachers, 200);
    }

    public function getProject($project_id)
    {
        $project = $this->userManagement->getProjectById($project_id);
        return response()->json($project, 200);
    }

    public function getGroupProject($student_id)
    {
        $group = $this->userManagement->getGroupProjectByStudent($student_id);
        $project = $this->userManagement->getProjectById(Arr::get($group, 'project_id'));
        return response()->json($project, 200);
    }

    public function getProjectTeacherResponse($teacher_id)
    {
        $project = $this->userManagement->getProjectByTeacher($teacher_id);
        return response()->json($project, 200);
    }

    public function getProjectAAResponse($aa_id)
    {
        $project = $this->userManagement->getProjectByAA($aa_id);
        return response()->json($project, 200);
    }

    public function getAllProject()
    {
        $project = $this->userManagement->getAllProject();
        return response()->json($project, 200);
    }

    public function getStudentNoGroup()
    {
        $students = $this->userManagement->getStudentNoGroup();
        return response()->json($students, 200);
    }

    public function editProfileStudent(Request $request)
    {

        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'student_id' => 'required',
            'department' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();

        $has_image = Arr::has($data['image'], null);
        if ($has_image) {
            $custom_file_name = $data['student_id'] . '.jpg';
            $path = $request->file('image')->storeAs('images', $custom_file_name);
        }

        $result = $this->userManagement->editProfileStudent($data);

        return response()->json('สำเร็จ', 200);
    }
}
