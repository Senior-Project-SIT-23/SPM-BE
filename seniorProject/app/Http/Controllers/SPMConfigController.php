<?php

namespace App\Http\Controllers;

use App\Repositories\SPMConfigRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SPMConfigController extends Controller
{
    private $SPMConfig;
    
    public function __construct(SPMConfigRepositoryInterface $spmConfig)

    {
        $this->spmConfig = $spmConfig;
    }

    public function storeConfigProject(Request $request){
        
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

    public function indexConfigProjectByYear($year_of_study){
        $config = $this->spmConfig->getConfigByYear($year_of_study);
        return response()->json($config, 200);
    }
}
