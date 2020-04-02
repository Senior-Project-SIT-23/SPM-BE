<?php

namespace App\Repositories;

interface UserManagementRepositoryInterface
{
   public function createProject($data);
   public function getAllStudent();
   public function getAllTeacher();
}