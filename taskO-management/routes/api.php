<?php

use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\auth\UserController;
use App\Http\Controllers\api\TeamController;
use App\Models\Team;
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
Route::put('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'delete']);