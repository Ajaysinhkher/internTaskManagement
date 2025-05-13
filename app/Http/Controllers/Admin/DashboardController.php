<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for stats
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $activeTasks = Task::whereIn('status', ['pending', 'in_progress'])->count();
        $completedTasks = Task::where('status', 'completed')->count();

        // Get recent users with their tasks count
        $recentUsers = User::latest()->take(5)->get();
         
            

        // dd($recentUsers);

        // Get recent tasks with their relationships
        $recentTasks = Task::with(['users'])
            ->latest()
            ->take(5)
            ->get();

        // dd($recentTasks->toArray());

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTasks',
            'activeTasks',
            'completedTasks',
            'recentUsers',
            'recentTasks'
        ));
    }
}
