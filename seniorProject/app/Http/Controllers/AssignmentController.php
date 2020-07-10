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

    public function editAssignment(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'assignment_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->assignment->updateAssignment($data);

        return response()->json('สำเร็จ', 200);
    }

    public function deleteAssignment(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'assignment_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $assignment_id = $request->all();
        $this->assignment->deleteAssignmentById($assignment_id);

        return response()->json('สำเร็จ', 200);
    }

    public function storeRubric(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'title' => 'required',
            'criterions' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->assignment->createRubric($data);
        return response()->json('สำเร็จ', 200);
    }

    public function indexAllAssignment()
    {
        $assignments = $this->assignment->getAllAssignment();
        return response()->json($assignments, 200);
    }

    public function indexAssignment($assignment_id)
    {
        $assignments = $this->assignment->getAssignmentById($assignment_id);
        return response()->json($assignments, 200);
    }
}
