<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function getTasks(Request $request)
    {
        $allTasks = Task::all();
        return response()->json($allTasks);
    }

    public function getTask(Task $task, Request $request)
    {
        return response()->json($task);
    }

    /*public function doneTask (Task $task, Request $request) {
        $task->done = !$task->done;
        $task->save();
        return response()->json($task);
    }*/

    public function doneTask(Task $task, Request $request)
    {
        $task->done = $request->done;
        $task->save();
        return response()->json($request);
    }

    public function addTask(Request $request)
    {
        $newTask = new Task();
        $newTask->title = $request->title;
        $newTask->subtitle = $request->subtitle;
        $newTask->done = false;
        $newTask->save();
        return response()->json($newTask);
    }

    public function editTask(Task $task, Request $request)
    {
        $task->title = $request->title;
        $task->subtitle = $request->subtitle;
        $task->save();
        return response()->json($request);
    }

    public function deleteTask(Task $task, Request $request)
    {
        $task->delete();
        return response()->json($task);
    }
}
