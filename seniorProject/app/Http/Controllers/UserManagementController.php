<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserManagementRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller 
{

    private $userManagement;

    public function __construct(UserManagementRepositoryInterface $userManagement)
    
    {
        $this->userManagement = $userManagement;
    }

    public function storeProject(Request $request)
    {
        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'project_name' => 'required',
            'department' => 'required',
            'student_id' => 'required',
            'teacher_id' => 'required',
            'project_detail' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json('กรุณากรอกข้อมูลให้ครบ',400);;
        }
        //
        $data = $request->all();
        $result = $this->userManagement->createProject($data);
        if($result){
            return response()->json($result,500);
        }
        return response()->json('สำเร็จ',200);

    }

    public function getProject($project_id){
        $project = $this->userManagement->getProjectById($project_id);
        return response()->json($project, 200);
    }

    public function editProject(Request $request){
        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'project_id' => 'required',
            'group_id' => 'required',
            'department' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json('กรุณากรอกข้อมูลให้ครบ',400);;
        }
        //
        $data = $request->all();
        $this->userManagement->updateProject($data);
        return response()->json('สำเร็จ',200);

    }

    public function indexStudent(){
        $students = $this->userManagement->getAllStudent();
        return response()->json($students, 200);
    }

    public function indexTeacher(){
        $teachers = $this->userManagement->getAllTeacher();
        return response()->json($teachers, 200);
    }
}