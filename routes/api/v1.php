<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
})->middleware('guest');

Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
Route::put('tasks/{task}/toggle', [TaskController::class, 'toggleCompleted'])->name('tasks.toggle')->middleware('auth:sanctum');
