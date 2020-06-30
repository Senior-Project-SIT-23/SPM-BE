<?php

namespace App\Repositories;

use App\Model\Assignment;
use App\Model\Attachment;
use App\Model\ResponsibleAssignment;
use App\Model\Rubric;
use App\Model\Criteria;
use App\Model\CriteriaDetail;
use App\Model\CriteriaScore;


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

        $attachment = new Attachment;
        $attachment->assignment_id = $assignment->assignment_id;
        $attachment->attachment = $data['attachment'];
        $attachment->save();

        foreach ($data['teacher_id'] as $value) {
            $responsible_assignment = new ResponsibleAssignment;
            $responsible_assignment->teacher_id = $value;
        }
        $responsible_assignment->assignment_id = $assignment->assignment_id;
        $responsible_assignment->save();
    }

    public function createRubric($data)
    {
        $rubric = new Rubric;
        $rubric->rubric_name = $data['rubric_name'];
        $rubric->save();

        foreach ($data['criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria__name = $value['tile'];
            $criteria->rubric = $rubric->rubric_id;
            $criteria->save();

            foreach ($value['score'] as $temp)
            $criteria_detail = new CriteriaDetail;
            $criteria_detail->criteria_detail = $temp['name'];
            $criteria_detail->save();
            
        }
     
        
            
    
        

        
    }

    public function getAllAssignment()
    {
        $assignments = Assignment::all();
        return $assignments;
    }
}
