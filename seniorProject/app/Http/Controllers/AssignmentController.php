<?php

namespace App\Http\Controllers;

use App\Repositories\AssignmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AssignmentController extends Controller
{
    private $assignment;

    public function __construct(AssignmentRepositoryInterface $assignment)

    {
        $this->assignment = $assignment;
    }

    public function storeAssignment(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'assignment_title' => 'required',
            'due_date' => 'required',
            'rubric_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->assignment->createAssignment($data);

        return response()->json('สำเร็จ', 200);
    }

    public function storeRubric(Request $request)
    {
        $data = $request->all();
        $this->assignment->createRubric($data);
        return response()->json('สำเร็จ', 200);
    }


    public function indexAllAssignment()
    {
        $assignments = $this->assignment->getAllAssignment();
        return response()->json($assignments, 200);
    }
}
