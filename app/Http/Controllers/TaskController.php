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
    
    public function getTaskById($id){
        try {
            Log::info('Getting task with id: '.$id);
            $userId = auth()->user()->id;
            $task = Task::where('user_id','=',$userId)->find($id);
            if(!$task){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Task not found'
                    ]
                );
            }
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task retrieved',
                    'task' => $task
                ]
            );
        }catch(\Exception $exception){
            Log::error('Error getting task: '.$exception->getMessage());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Error getting task'
                ]
            );
        }
    }
    public function deleteTaskById($id){
        try{
            Log::info('Deleting task with id: '.$id);
            $userId = auth()->user()->id;
            $task = Task::where('user_id','=',$userId)->find($id);
            if(!$task){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Task not found'
                    ]
                );
            }
            $task->delete();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task deleted'
                ]
            );
        }catch(\Exception $exception){
            Log::error('Error deleting task: '.$exception->getMessage());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Error deleting task'
                ]
            );
        }
    }

    public function updateTask($id, Request $request) {
        try {
            Log::info('Updating task with id: '.$id);
            $userId = auth()->user()->id;
            $task = Task::where('user_id','=',$userId)->find($id);
            if(!$task){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Task not found'
                    ]
                );
            }
            $task->title = $request->input('title');
            $task->save();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task updated',
                    'task' => $task
                ]
            );
        }catch(\Exception $exception){
            Log::error('Error updating task: '.$exception->getMessage());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Error updating task'
                ]
            );
        }
    }
}
