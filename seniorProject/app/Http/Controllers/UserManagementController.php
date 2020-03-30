<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserManagementRepositoryInterface;

class UserManagementController extends Controller 
{

    private $userManagement;

    public function __construct(UserManagementRepositoryInterface $userManagement)
    
    {
        $this->userManagement = $userManagement;
    }

    public function storeProject(Request $request)
    {
        $data = $request->all();
        $this->userManagement->createProject($data);
    }

    public function index()
    {
        $users = $this->userManagement->getAllUser();
        return response()->json($users, 200);
    }
}
