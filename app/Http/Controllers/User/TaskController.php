<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;

class TaskController extends Controller
{
    public function index()
    {

        try{

            $tasks = Task::whereHas('users', function ($query) {
                $query->where('users.id', Auth::id()); // 
            })->with('assignedBy')->latest()->get();
        
            foreach ($tasks as $task) {
                $task->assigned_by_admin = Admin::find($task->assigned_by); // Fetch the admin by the assigned_by ID
            }
            
            return view('user.tasks.index', compact('tasks'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading tasks: ' . $e->getMessage());
        }
    }



   public function show($id)
    {

        try{

            $task = Task::whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })->with(['assignedBy', 'comments.commentable'])->findOrFail($id); 
        
            $task->assigned_by_admin = Admin::find($task->assigned_by);
        
            return view('user.tasks.show', compact('task'));

        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading task: ' . $e->getMessage());
        }
    }  
    
}
