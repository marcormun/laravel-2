<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function createTask (Request $request) {
        try {
            $task = new Task();
            $task->title = $request->input('title');
            $task->user_id = auth()->user()->id;
            $task->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task created',
                    'task' => $task
                ]
            );
        }catch(\Exception $exception){
            Log::error('Error creating task: '.$exception->getMessage());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Error creating task'
                ]
            );
        }
    }

    public function getTasksByUserId(){
        try {
            $userId = auth()->user()->id;
            $tasks = Task::where('user_id', $userId)->get()->toArray();
            // $tasks = User::find($userId)->tasks;
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Tasks retrieved',
                    'tasks' => $tasks
                ]
            );
        }catch(\Exception $exception){
            Log::error('Error getting tasks: '.$exception->getMessage());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Error getting tasks'
                ]
            );
        }
    }
}
