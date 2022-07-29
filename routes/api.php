<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    }
);

//USERS
Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::get('/users', [UserController::class, 'getUserById']);
    }
);

//ROLES

Route::group(
    ['middleware' => ['jwt.auth','isSuperAdmin']],
    function () {
        Route::post('/superAdminRole/{id}', [UserController::class, 'superAdminRole']);
        Route::delete('/deleteSuperAdminRole/{id}', [UserController::class, 'deleteSuperAdminRole']);
    }
);

//TASKS

Route::group(
    ['middleware' => 'jwt.auth'],
    function () {
        Route::post('/tasks', [TaskController::class, 'createTask']);
        Route::get('/tasks', [TaskController::class, 'getTasksByUserId']);
        Route::get('/tasks/{id}', [TaskController::class, 'getTaskById']);
        Route::put('/tasks/{id}', [TaskController::class, 'updateTask']);
        Route::delete('/tasks/{id}', [TaskController::class, 'deleteTaskById']);
    }
);