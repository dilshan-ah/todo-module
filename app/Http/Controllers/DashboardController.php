<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $upcomingTasks = Task::where('status','upcoming')->get();
        $inprogressTasks = Task::where('status','inprogress')->get();
        $pendingTasks = Task::where('status','pending')->get();
        $completedTasks = Task::where('status','completed')->get();

        return view('dashboard',compact('users','upcomingTasks','inprogressTasks','pendingTasks','completedTasks'));
    }
}
