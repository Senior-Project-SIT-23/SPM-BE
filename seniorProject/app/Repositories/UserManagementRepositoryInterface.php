<?php

namespace App\Repositories;

interface UserManagementRepositoryInterface
{
   public function createProject($data);
   public function updateProject($data);
   public function getAllStudent();
   public function getAllTeacher();
   public function getProjectById($project_id);
   
}