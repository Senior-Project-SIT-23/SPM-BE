<?php

namespace App\Repositories;

interface AssignmentRepositoryInterface
{
    public function createAssignment($data);
    public function updateAssignment($data);
    public function deleteAssignmentById($assignment_id);
    public function createRubric($data);
    public function getAllAssignment();
    public function getAssignmentById($assignment_id);
}
