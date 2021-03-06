<?php

namespace App\Http\Controllers;

use App\Model\Student;
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
            'student_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        //
        $data = $request->all();
        $result = $this->userManagement->createProject($data);

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

    public function indexAA()
    {
        $aas = $this->userManagement->getAllAA();
        return response()->json($aas, 200);
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

        if ($data['image']) {
            $temp = $data['image']->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            // $custom_file_name = 'test' . ".jpg";
            $custom_file_name = $data['student_id'] . ".jpg";
            $path = $request->file('image')->storeAs('/images', $custom_file_name);
            $data['path'] = $path;
        }

        $this->userManagement->editProfileStudent($data);

        return response()->json('สำเร็จ', 200);
    }

    public function editProfileTeacher(Request $request)
    {

        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'teacher_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();

        if ($data['image']) {
            $temp = $data['image']->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            // $custom_file_name = 'test' . ".jpg";
            $custom_file_name = $data['teacher_id'] . ".jpg";
            $path = $request->file('image')->storeAs('/images', $custom_file_name);
            $data['path'] = $path;
        }

        $this->userManagement->editProfileTeacher($data);

        return response()->json('สำเร็จ', 200);
    }

    public function editProfileAA(Request $request)
    {

        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'aa_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();

        if ($data['image']) {
            $temp = $data['image']->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            // $custom_file_name = 'test' . ".jpg";
            $custom_file_name = $data['aa_id'] . ".jpg";
            $path = $request->file('image')->storeAs('/images', $custom_file_name);
            $data['path'] = $path;
        }

        $this->userManagement->editProfileAA($data);

        return response()->json('สำเร็จ', 200);
    }
}
