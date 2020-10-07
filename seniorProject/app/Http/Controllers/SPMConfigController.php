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

    public function indexNotification($student_id)
    {
        $notification = $this->spmConfig->getNotification($student_id);
        return response()->json($notification, 200);
    }

    public function storeNotification(Request $request)
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
        $this->spmConfig->readNotification($data);
        return response()->json('สำเร็จ', 200);
    }
}
