<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    Route::post('/tasks/{taskId}/comments', [CommentController::class, 'store']);
    Route::get('/tasks/{taskId}/comments', [CommentController::class, 'index']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::post('/teams/{teamId}/users', [TeamController::class, 'addUser']);
    Route::delete('/teams/{teamId}/users/{userId}', [TeamController::class, 'removeUser']);
});
