<?php

namespace App\Repositories;

interface UserManagementRepositoryInterface
{
   public function createProject($data);
   public function updateProject($data);
   public function deleteProjectById($project_id);
   public function getAllStudent();
   public function getAllTeacher();
   public function getAllProject();
   public function getProjectById($project_id);
   public function getProjectByTeacher($teacher_id);
   public function getProjectByAA($aa_id);
}