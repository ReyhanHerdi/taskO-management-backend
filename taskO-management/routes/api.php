<?php

use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\auth\UserController;
use App\Http\Controllers\api\ProjectController;
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
Route::put('/users/update/{id}', [UserController::class, 'update']);

// Team
Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);
Route::get('/user-teams/{id}', [TeamController::class, 'showByUserId']);
Route::get('/team-members/{id}', [TeamController::class, 'showByTeamId']);
Route::get('/team-projects/{id}', [TeamController::class, 'showProject']);
Route::put('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'delete']);

// Project
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('projects-team/{id}', [ProjectController::class, 'showByTeamId']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('projects/{id}', [ProjectController::class, 'destroy']);
