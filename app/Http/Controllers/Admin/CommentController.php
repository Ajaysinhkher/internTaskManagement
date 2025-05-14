<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

class CommentController extends Controller
{
 public function store(Request $request)
{
  // dd($request->toArray());
    $demo = $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'message' => 'required|string',
    ]);

    // dd($demo);


    $task = Task::findOrFail($request->task_id);

    // dd($task->toArray());
    // Detect if admin or user is authenticated
    $authGuard = auth('admin')->check() ? 'admin' : 'web';
    $user = auth($authGuard)->user();

    // dd($user);
    // Create comment using morph relationship
    $comment = $task->comments()->create([
        'message' => $request->message,
        'commentable_id' => $user->id,
        'commentable_type' => get_class($user),
    ]);

    // dd($comment);

    return redirect()->back()->with('success', 'Comment added successfully!');
}

}
