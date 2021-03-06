<?php

namespace App\Http\Controllers;

use App\Repositories\SPMConfigRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SPMConfigController extends Controller
{
    private $spmConfig;

    public function __construct(SPMConfigRepositoryInterface $spmConfig)

    {
        $this->spmConfig = $spmConfig;
    }

    public function storeConfig(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'year_of_study' => 'required',
            'number_of_member_min' => 'required',
            'number_of_member_max' => 'required',
            'student_one_more_group' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->spmConfig->createConfig($data);
        return response()->json('สำเร็จ', 200);
    }

    public function indexConfig()
    {
        $config = $this->spmConfig->getConfig();
        return response()->json($config, 200);
    }

    public function indexConfigByYear($year_of_study)
    {
        $config = $this->spmConfig->getConfigByYear($year_of_study);
        return response()->json($config, 200);
    }

    public function indexStudentNotification($student_id)
    {
        $notification = $this->spmConfig->getStudentNotification($student_id);
        return response()->json($notification, 200);
    }

    public function storeStudentNotification(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'notification_id' => 'required',
            'student_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->spmConfig->readStudentNotification($data);
        return response()->json('สำเร็จ', 200);
    }

    public function indexTeacherNotification($teacher_id)
    {
        $notification = $this->spmConfig->getTeacherNotification($teacher_id);
        return response()->json($notification, 200);
    }

    public function storeTeacherNotification(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล 
        $validator =  Validator::make($request->all(), [
            'notification_id' => 'required',
            'teacher_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->spmConfig->readTeacherNotification($data);
        return response()->json('สำเร็จ', 200);
    }

    public function indexAANotification($aa_id)
    {
        $notification = $this->spmConfig->getAANotification($aa_id);
        return response()->json($notification, 200);
    }

    public function storeAANotification(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล 
        $validator =  Validator::make($request->all(), [
            'notification_id' => 'required',
            'aa_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->spmConfig->readAANotification($data);
        return response()->json('สำเร็จ', 200);
    }
}
