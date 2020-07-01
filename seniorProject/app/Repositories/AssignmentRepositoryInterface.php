<?php

namespace App\Repositories;

interface AssignmentRepositoryInterface
{
    public function createAssignment($data);
    public function deleteAssignmentById($assignment_id);
    public function createRubric($data);
    public function getAllAssignment();
}
