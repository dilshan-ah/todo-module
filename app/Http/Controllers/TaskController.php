<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
class TaskController extends Controller
{
    public function store(Request $request)
    {
        $task = new Task();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->created_by = Auth::id();
        $task->given_to = $request->given;
        $task->status = $request->status;
        
        if($task->save())
        {
            return redirect()->back()->with('status', 'Task created successfully');
        }else{
            return redirect()->back()->with('error', 'Failed to create task');
        }
        
    }

    public function delete(string $id)
    {
        $task = Task::where('id',$id)->first();

        $task->delete();

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $task = Task::where('id',$id)->first();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->given_to = $request->given;
        $task->status = $request->status;
        
        if($task->save())
        {
            return redirect()->back()->with('status', 'Task updated successfully');
        }else{
            return redirect()->back()->with('error', 'Failed to update task');
        }
        
    }
}
