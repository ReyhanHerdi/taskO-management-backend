<?php

use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\auth\UserController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::get('/auth', [LoginController::class, 'authCheck']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

// User
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/users/update/{id}', [UserController::class, 'update']);

// Team
Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);
Route::get('/team/{id}', [TeamController::class, 'showById']);
Route::get('/user-teams/{id}', [TeamController::class, 'showByUserId']);
Route::get('/team-members/{id}', [TeamController::class, 'showByTeamId']);
Route::get('/team-projects/{id}', [TeamController::class, 'showProject']);
Route::put('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'delete']);
Route::post('/member-store/{id}', [TeamController::class, 'memberStore']);

// Project
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('projects-user/{id}', [ProjectController::class, 'showByUserId']); // Belom kepake
Route::get('projects-team/{id}', [ProjectController::class, 'showByTeamId']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('projects/{id}', [ProjectController::class, 'destroy']);

// Task
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/task-executor/{id}', [TaskController::class, 'taskByExecutor']);
Route::post('/task-executor', [TaskController::class, 'taskExecutorStore']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
Route::delete('/task-executor/{id}', [TaskController::class, 'taskExecutorDestroy']);
