<?php

namespace App\Http\Controllers;

use App\Repositories\AssignmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AssignmentController extends Controller
{
    private $assignment;
    
    public function __construct(AssignmentRepositoryInterface $assignment)

    {
        $this->assignment = $assignment;
    }
}
