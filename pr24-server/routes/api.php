<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;

// auth/
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('decode', [AuthController::class, 'decode']);
});

// user
Route::apiResource('user', UserController::class);
Route::post('user/reset/{id}', [UserController::class, 'resetPassword']);

// student
Route::apiResource('student', StudentController::class);
Route::post('student-login', [StudentController::class, 'login']);

// seat
Route::apiResource('seat', SeatController::class);

// feedback
Route::apiResource('feedback', FeedbackController::class);
Route::get('feedback/student/{id}', [FeedbackController::class, 'getFeedbackByStudentId']);

