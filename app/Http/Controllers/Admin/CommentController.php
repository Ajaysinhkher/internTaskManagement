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
  
    $demo = $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'message' => 'required|string',
    ]);

  
    try{

      $task = Task::findOrFail($request->task_id);
  
      $authGuard = auth('admin')->check() ? 'admin' : 'web';
      $user = auth($authGuard)->user();
  
      $comment = $task->comments()->create([
          'message' => $request->message,
          'commentable_id' => $user->id,
          'commentable_type' => get_class($user),
      ]);
    }catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error adding comment: ' . $e->getMessage());
    }

    return redirect()->back()->with('success', 'Comment added successfully!');
}

}
