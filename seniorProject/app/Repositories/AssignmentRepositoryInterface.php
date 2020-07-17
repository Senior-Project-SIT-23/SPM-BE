<?php

namespace App\Repositories;

interface AssignmentRepositoryInterface
{
    public function createAssignment($data);
    public function updateAssignment($data);
    public function deleteAssignmentById($assignment_id);
    public function createRubric($data);
    public function updateRubric($data);
    public function getAllAssignment();
    public function getAssignmentById($assignment_id);
    public function deleteRubric($rubric_id);
    public function getAllRubric();
    public function getRubricByID($rubric_id);
    public function addAttachment($file,$data);
    public function getAllAttachment();
    public function getAttachmentByAssignmentID($assignment_id);
    public function deleteAttachment($data);
    
    //Test
    public function createAttachment($file,$data);
}
