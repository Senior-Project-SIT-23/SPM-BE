<?php

namespace App\Repositories;

use App\Model\Assignment;
use App\Model\Attachment;
use App\Model\ResponsibleAssignment;
use App\Model\Rubric;
use App\Model\Criteria;
use App\Model\CriteriaDetail;
use App\Model\CriteriaScore;
use App\Model\Feedback;
use App\Model\Group;
use App\Model\SendAssignment;
use App\Model\StatusAssignment;
use App\Model\Teacher;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function createAssignment($data)
    {
        $assignment = new Assignment;
        $assignment->assignment_title = $data['assignment_title'];
        $assignment->assignment_detail = $data['assignment_detail'];
        $assignment->due_date = $data['due_date'];
        $assignment->due_time = $data['due_time'];
        $assignment->date_time = $data['due_date'] . " " . $data['due_time'];
        $assignment->rubric_id = $data['rubric_id'];
        $assignment->teacher_id = $data['teacher_id'];
        $assignment->save();

        foreach ($data['responsible_teacher'] as $value) {
            $responsible_assignment = new ResponsibleAssignment;
            $responsible_assignment->teacher_id = $value;
            $responsible_assignment->assignment_id = $assignment->id;
            $responsible_assignment->save();
        }

        // $status = new StatusAssignment;
        // $status->status = 'Not Submitted'; 
        // $status->assignment_id = $assignment->id;
    }

    public function updateAssignment($data)
    {
        foreach ($data['delete_teacher_id'] as $value) {
            ResponsibleAssignment::where('responsible_assignment.assignment_id', $data['assignment_id'])
                ->where('responsible_assignment.teacher_id', "$value")->delete();
        }
        foreach ($data['delete_attachment_name'] as $value) {
            Attachment::where('attachments.assignment_id', $data['assignment_id'])
                ->where('attachments.attachment_name', "$value")->delete();
            unlink(storage_path('app/attachments/' . $value));
        }
        Assignment::where('assignments.assignment_id', $data['assignment_id'])
            ->update([
                'assignments.assignment_title' => $data['assignment_title'],
                'assignments.assignment_detail' => $data['assignment_detail'],
                'assignments.due_date' => $data['due_date'],
                'assignments.due_time' => $data['due_time'],
                'assignments.rubric_id' => $data['rubric_id']
            ]);

        foreach ($data['teacher_id'] as $value) {
            $responsible_assignment = new ResponsibleAssignment;
            $responsible_assignment->teacher_id = $value;
            $responsible_assignment->assignment_id = $data['assignment_id'];
            $responsible_assignment->save();
        }
    }


    public function deleteAssignmentById($assignment_id)
    {
        ResponsibleAssignment::where('responsible_assignment.assignment_id', $assignment_id)->delete();


        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        foreach ($attachment as $value) {
            unlink(storage_path('app/attachments/' . $value->attachment_name));
        }

        Attachment::where('attachments.assignment_id', $assignment_id)->delete();
        Assignment::where('assignments.assignment_id', $assignment_id)->delete();
    }

    public function createRubric($data)
    {
        $rubric = new Rubric;
        $rubric->rubric_title = $data['rubric_title'];
        $rubric->save();

        foreach ($data['criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria_name = $value['criteria_name'];

            $criteria->rubric_id = $rubric->id;
            $criteria->save();

            foreach ($value['criteria_detail'] as $temp) {
                $criteria_detail = new CriteriaDetail;
                $criteria_detail->criteria_detail = $temp['name'];
                $criteria_detail->criteria_id = $criteria->id;
                $criteria_detail->save();

                $criteria_score = new CriteriaScore();
                $criteria_score->criteria_score = $temp['value'];
                $criteria_score->criteria_detail_id = $criteria_detail->id;
                $criteria_score->save();
            }
        }
    }

    public function updateRubric($data)
    {
        Rubric::where('rubric.rubric_id', $data['rubric_id'])->update(['rubric.rubric_title' => $data['rubric_title']]);

        foreach ($data['delete_criteria'] as $value) {
            Criteria::where('criteria.criteria_id', "$value")->delete();
        }

        foreach ($data['edit_criterions'] as $value) {

            foreach ($value['delete_criteria_deteail'] as $temp) {
                CriteriaDetail::where('criteria_detail.criteria_detail_id', "$temp")->delete();
            }

            Criteria::where('criteria_id', $value['criteria_id'])->update(['criteria_name' => $value['criteria_name']]);
            foreach ($value['criteria_detail'] as $temp) {
                $criteria_score_id = $temp['criteria_detail_id'];
                CriteriaDetail::where('criteria_detail_id', $temp['criteria_detail_id'])
                    ->update(['criteria_detail' => $temp['name']]);
                CriteriaScore::where('criteria_score_id', $criteria_score_id)
                    ->update(['criteria_score' => $temp['value']]);
            }
        }

        foreach ($data['create_criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria_name = $value['criteria_name'];

            $criteria->rubric_id = $data['rubric_id'];
            $criteria->save();

            foreach ($value['criteria_detail'] as $temp) {
                $criteria_detail = new CriteriaDetail;
                $criteria_detail->criteria_detail = $temp['name'];
                $criteria_detail->criteria_id = $criteria->id;
                $criteria_detail->save();

                $criteria_score = new CriteriaScore();
                $criteria_score->criteria_score = $temp['value'];
                $criteria_score->criteria_detail_id = $criteria_detail->id;
                $criteria_score->save();
            }
        }
    }

    public function deleteRubric($rubric_id)
    {
        Rubric::where('rubric.rubric_id', $rubric_id)->delete();
    }

    public function getAllAssignment()
    {
        $assignments = Assignment::join('teachers','teachers.teacher_id','=','assignments.teacher_id')->get();
        return $assignments;
    }

    public function getStudentAssignmentById($assignment_id, $student_id)
    {
        $assignment = Assignment::where('assignments.assignment_id', $assignment_id)->first();
        $teacher = Teacher::where('teacher_id', $assignment->teacher_id)->first();
        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        $response = ResponsibleAssignment::where('responsible_assignment.assignment_id', $assignment_id)->get();
        $rubric_id = $assignment->rubric_id;
        $rubric = Rubric::where('rubric.rubric_id', $rubric_id)
            ->join('criteria', 'criteria.rubric_id', '=', 'rubric.rubric_id')
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();;
        $feedback = Feedback::where('assignment_id', $assignment_id)->first();
        $student = Group::where('student_id', $student_id)->first();
        $status = StatusAssignment::where('project_id', $student->project_id)
            ->where('assignment_id', $assignment_id)->first();
        $file_assignment = SendAssignment::where('project_id', $student->project_id)
            ->where('assignment_id', $assignment_id)->get();


        $assignment->attachment = $attachment;
        $assignment->teacher = $teacher;
        $assignment->responsible_teacher = $response;
        $assignment->rubric = $rubric;
        $assignment->status = $status;
        $assignment->file_assignment = $file_assignment;
        $assignment->feedback = $feedback;

        return $assignment;
    }

    public function getAllRubric()
    {
        $rubric = Rubric::all();
        return $rubric;
    }

    public function getRubricByID($rubric_id)
    {
        $rubric = Rubric::where('rubric.rubric_id', $rubric_id)->first();
        $criteria = Criteria::where('criteria.rubric_id', $rubric_id)
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $rubric->criterions = $criteria;

        return $rubric;
    }

    public function addAttachment($data)
    {
        $assignment = Assignment::where('assignments.assignment_title', $data['assignment_title'])->first();
        $assignment_id = $assignment->assignment_id;
        foreach ($data['attachment'] as $key => $values) {
            $attachment = new Attachment();
            $temp = $values->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            $custom_file_name = $data['assignment_title'] . "_" . "$key" . ".$extension";
            $path = $values->storeAs('/attachments', $custom_file_name);
            $attachment->attachment = $path;
            $attachment->attachment_name = $custom_file_name;
            $attachment->assignment_id = $assignment_id;
            $attachment->save();
        }
    }

    public function getAllAttachment()
    {
        $attachment = Attachment::all();
        return $attachment;
    }

    public function getAttachmentByAssignmentID($assignment_id)
    {
        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        return $attachment;
    }

    public function deleteAttachment($data)
    {
        Attachment::where('attachments.attachment_id', $data['attachment_id'])->delete();
        unlink(storage_path('app/attachments/' . $data['attachment_name']));
    }


    public function sendAssignment($data)
    {
        $group = Group::where('student_id', $data['student_id'])->first();
        $project_id = $group->project_id;
        if ($data['send_file_assignment']) {
            foreach ($data['send_file_assignment'] as $values) {
                if($values){
                    $send_assignment = new SendAssignment;
                    $temp = $values->getClientOriginalName();
                    $extension = pathinfo($temp, PATHINFO_EXTENSION);
                    $custom_file_name = $project_id . "_" . "$temp" . ".$extension";
                    $path = $values->storeAs('/send_assignment', $custom_file_name);
                    $send_assignment->send_assignment = $path;
                    $send_assignment->send_assignment_name = $custom_file_name;
                    $send_assignment->assignment_id = $data['assignment_id'];
                    $send_assignment->project_id = $project_id;
                    $send_assignment->save();
                    $status = new StatusAssignment;
                    $status->status = $data['status'];
                    $status->assignment_id = $data['assignment_id'];
                    $status->project_id = $project_id;
                    $status->save();
                }
            }
        }

        if ($data['delete_file_assignment']) {
            foreach ($data['delete_file_assignment'] as $values) {
                if($values){
                    $name = SendAssignment::where('send_assignment_id',$values)->first();
                    $send_assignment_name = $name->send_assignment_name; 
                    SendAssignment::where('send_assignment_id', $values)->delete();
                    unlink(storage_path('app/send_assignment/' . $send_assignment_name));

                }
            }
        }
    }

    //Test create attachment
    public function createAttachment($data)
    {
        foreach ($data['attachment'] as $key => $values) {
            $attachment = new Attachment();
            $temp = $values->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            $custom_file_name = $data['assignment_title'] . "_" . "$key" . ".$extension";
            $path = $values->storeAs('/attachments', $custom_file_name);
            $attachment->attachment = $path;
            $attachment->attachment_name = $custom_file_name;
            $attachment->save();
        }
    }
}
