<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        // get only the authenticated user's tasks
         $tasks = auth()->user()->tasks;
        return view('user.dashboard',compact('tasks'));
    }
}
