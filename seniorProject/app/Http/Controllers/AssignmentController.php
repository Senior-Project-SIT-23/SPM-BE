<?php

namespace App\Http\Controllers;

use App\Model\Attachment;
use App\Repositories\AssignmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Attachments;


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
        
        if($data['attachment']){
            
            $temp = $data['attachment']->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            $path = $request->file('attachment')->storeAs('/attachment_assignment', $temp);
            $data['path'] = $path;
        }
        // foreach ($data['attachment'] as $value) {
        //     $attachment = new Attachment;
        //     $attachment->attachment = $value;
        //     $attachment->assignment_id = $assignment->id;
        //     $attachment->save();
        // }

        // if ($data['image']) {
        //     $temp = $data['image']->getClientOriginalName();
        //     $extension = pathinfo($temp, PATHINFO_EXTENSION);
        //     // $custom_file_name = 'test' . ".jpg";
        //     $custom_file_name = $data['aa_id'] . ".jpg";
        //     $path = $request->file('image')->storeAs('/images', $custom_file_name);
        //     $data['path'] = $path;
        // }

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
            'rubric_title' => 'required',
            'criterions' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }
        $data = $request->all();
        $this->assignment->createRubric($data);
        return response()->json('สำเร็จ', 200);
    }

    public function editRubric(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'rubric_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();
        $this->assignment->updateRubric($data);

        return response()->json('สำเร็จ', 200);
    }

    public function deleteRubric(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'rubric_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $rubric_id= $request->all();
        $this->assignment->deleteRubric($rubric_id);

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

    public function indexAllRubric()
    {
        $rubric = $this->assignment->getAllRubric();
        return response()->json($rubric, 200);
    }

    public function indexRubric($rubric_id)
    {
        $rubric = $this->assignment->getRubricByID($rubric_id);
        return response()->json($rubric, 200);
    }
}
