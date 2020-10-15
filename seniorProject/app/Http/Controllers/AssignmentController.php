<?php

namespace App\Http\Controllers;

use App\Repositories\AssignmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;


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
            'due_time' => 'required',
            'rubric_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();
        
        $this->assignment->createAssignment($data);

        $has_attachment = Arr::get($data, 'attachment');
        if ($has_attachment) {
            $this->assignment->addAttachment($data);
        }

        $status = 'create assignment';
        $this->assignment->createStudentNotification($data, $status);

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

        $has_attachment = Arr::get($data, 'attachment');
        if ($has_attachment) {
            $this->assignment->addAttachment($data);
        }

        $status = 'edit assignment';
        $this->assignment->createStudentNotification($data, $status);

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

        $rubric_id = $request->all();
        $this->assignment->deleteRubric($rubric_id);

        return response()->json('สำเร็จ', 200);
    }

    public function indexAllAssignment()
    {
        $assignments = $this->assignment->getAllAssignment();
        return response()->json($assignments, 200);
    }

    public function indexStudentAssignment($assignment_id, $student_id)
    {
        $assignments = $this->assignment->getStudentAssignmentById($assignment_id, $student_id);
        return response()->json($assignments, 200);
    }

    public function indexAssignment($assignment_id)
    {
        $assignments = $this->assignment->getAssignmentById($assignment_id);
        return response()->json($assignments, 200);
    }

    public function indexResponsibleAssignment($teacher_id)
    {
        $assignments = $this->assignment->getResponsibleAssignment($teacher_id);
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

    public function indexAllAttachment()
    {
        $attachment = $this->assignment->getAllAttachment();
        return response()->json($attachment, 200);
    }

    public function indexAttachment($assignment_id)
    {
        $attachment = $this->assignment->getAttachmentByAssignmentID($assignment_id);
        return response()->json($attachment, 200);
    }

    public function deleteAttachment(Request $request)
    {
        $data = $request->all();
        $this->assignment->deleteAttachment($data);
        return response()->json('สำเร็จ', 200);
    }

    public function storeSendAssignment(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'assignment_id' => 'required',
            'status' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();
        $this->assignment->sendAssignment($data);


        return response()->json('สำเร็จ', 200);
    }

    public function indexSendAssignmentByProjecdIdAndTeacherId($assignment_id, $teacher_id)
    {
        $send_assignment = $this->assignment->getSendAssignmentByTeacher($assignment_id, $teacher_id);
        return response()->json($send_assignment, 200);
    }

    public function indexSendAssignment($assignment_id)
    {
        $send_assignment = $this->assignment->getSendAssignment($assignment_id);
        return response()->json($send_assignment, 200);
    }

    public function indexSendAssignmentByProjecdId($assignment_id, $project_id)
    {
        $send_assignment = $this->assignment->getSendAssignmentByProjecdId($assignment_id, $project_id);
        return response()->json($send_assignment, 200);
    }

    public function storeAssessment(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'assignment_id' => 'required',
            'project_id' => 'required',
            'rubric_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();
        $assessment = $this->assignment->createAssessment($data);
        if ($assessment) {
            return response()->json($assessment, 500);
        }
        return response()->json('สำเร็จ', 200);
    }

    // Test
    public function storeAttachment(Request $request)
    {
        $data = $request->all();
        $this->assignment->createAttachment($data);

        return response()->json('สำเร็จ', 200);
    }
}
