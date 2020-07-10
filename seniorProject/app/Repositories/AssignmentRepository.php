<?php

namespace App\Repositories;

use App\Model\Assignment;
use App\Model\Attachment;
use App\Model\ResponsibleAssignment;
use App\Model\Rubric;
use App\Model\Criteria;
use App\Model\CriteriaDetail;
use App\Model\CriteriaScore;
use App\Model\Attachments;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function createAssignment($data)
    {
        $assignment = new Assignment;
        $assignment->assignment_title = $data['assignment_title'];
        $assignment->assignment_detail = $data['assignment_detail'];
        $assignment->due_date = $data['due_date'];
        $assignment->rubric_id = $data['rubric_id'];
        $assignment->status = "Not Submitted";
        $assignment->save();

        foreach ($data['attachment'] as $value) {
            $attachment = new Attachment;
            $attachment->attachment = $value;
            $attachment->assignment_id = $assignment->id;
            $attachment->save();
        }
        foreach ($data['teacher_id'] as $value) {
            $responsible_assignment = new ResponsibleAssignment;
            $responsible_assignment->teacher_id = $value;
            $responsible_assignment->assignment_id = $assignment->id;
            $responsible_assignment->save();
        }
    }

    public function updateAssignment($data)
    {
        foreach ($data['delete_teacher_id'] as $value) {
            ResponsibleAssignment::where('responsible_assignment.assignment_id', $data['assignment_id'])
                ->where('responsible_assignment.teacher_id', "$value")->delete();
        }
        foreach ($data['delete_attachment_id'] as $value) {
            Attachment::where('attachments.assignment_id', $data['assignment_id'])
                ->where('attachments.attachment_id', "$value")->delete();
        }
        Assignment::where('assignments.assignment_id', $data['assignment_id'])
            ->update([
                'assignments.assignment_title' => $data['assignment_title'],
                'assignments.assignment_detail' => $data['assignment_detail'],
                'assignments.due_date' => $data['due_date'],
                'assignments.rubric_id' => $data['rubric_id']
            ]);
        foreach ($data['attachment'] as $value) {
            $attachment = new Attachment;
            $attachment->attachment = $value;
            $attachment->assignment_id = $data['assignment_id'];
            $attachment->save();
        }
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
        Attachment::where('attachments.assignment_id', $assignment_id)->delete();
        Assignment::where('assignments.assignment_id', $assignment_id)->delete();
    }

    public function createRubric($data)
    {
        $rubric = new Rubric;
        $rubric->rubric_name = $data['title'];
        $rubric->save();

        foreach ($data['criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria_name = $value['criteria_name'];

            $criteria->rubric_id = $rubric->id;
            $criteria->save();

            foreach ($value['score'] as $temp) {
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

    public function getAllAssignment()
    {
        $assignments = Assignment::all();
        return $assignments;
    }

    public function getAssignmentById($assignment_id)
    {
        $assignment = Assignment::where('assignments.assignment_id', "$assignment_id")
            ->join('attachments','attachments.assignment_id','=','assignments.assignment_id')
            ->join('responsible_assignment','responsible_assignment.assignment_id','=','assignments.assignment_id')->get();
        return $assignment;
    }
}
