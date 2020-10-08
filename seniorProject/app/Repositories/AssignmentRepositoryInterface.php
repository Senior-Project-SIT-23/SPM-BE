<?php

namespace App\Repositories;

use PhpParser\Node\Expr\FuncCall;

interface AssignmentRepositoryInterface
{
    public function createAssignment($data);
    public function updateAssignment($data);
    public function deleteAssignmentById($assignment_id);
    public function createRubric($data);
    public function updateRubric($data);
    public function getAllAssignment();
    public function getStudentAssignmentById($assignment_id, $student_id);
    public function getAssignmentById($assignment_id);
    public function getResponsibleAssignment($teacher_id);
    public function deleteRubric($rubric_id);
    public function getAllRubric();
    public function getRubricByID($rubric_id);
    public function addAttachment($data);
    public function getAllAttachment();
    public function getAttachmentByAssignmentID($assignment_id);
    public function deleteAttachment($data);
    public function sendAssignment($data);
    public function getSendAssignmentByTeacher($assignment_id, $teacher_id);
    public function getSendAssignment($assignment_id);
    public function getSendAssignmentByProjecdId($assignment_id, $project_id);
    public function createAssessment($data);
    public function createStudentNotification($data, $status);

    //Test
    public function createAttachment($data);
}
