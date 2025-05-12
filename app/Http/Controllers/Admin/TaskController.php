<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::all();
            return view('admin.tasks.index', compact('tasks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading tasks: ' . $e->getMessage());
        }
    }
    

    public function create()
    {
        try{
            $users = User::all();
            return view('admin.tasks.create', compact('users'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accessing create task page: ' . $e->getMessage());
        }
      
    }

    public function store(Request $request)
    {

        // dd(auth('admin')->check());
        // dd(auth('admin')->id())

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'user_id' => 'required|array', // Ensure user_id is an array
            'user_id.*' => 'exists:users,id',
            

        ]);

        try {

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'assigned_by' => auth('admin')->id(), // or auth('admin')->id() if you're using a separate guard
            ]);
            

               // Attach selected users to the task
             $task->users()->attach($request->user_id);

            return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating task: ' . $e->getMessage());
        }
    }

    

    // show tasks:
    // public function show(Task $task)
    // {
    //     try {
    //         return view('admin.tasks.show', compact('task'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Error accessing task details: ' . $e->getMessage());
    //     }
    // }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting task: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $task = Task::findOrFail($id);
            $users = User::all();
            return view('admin.tasks.edit', compact('task', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accessing edit task page: ' . $e->getMessage());
        }
    }
    

    public function update(Request $request, Task $task)
    {

        // dd($request->toArray());
        $demo = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'user_id' => 'required|array', // Ensure user_id is an array
            'user_id.*' => 'exists:users,id',
        ]);

       


        try {
            $task->update(['title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'assigned_by' => auth('admin')->id()
            ]);
            
            // Sync the users with the task (removes old ones and adds new ones)
            $task->users()->sync($request->user_id);
            return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating task: ' . $e->getMessage());
        }
    }


}
