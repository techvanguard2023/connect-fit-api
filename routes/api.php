<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;

//Admin
use App\Http\Controllers\Admin\EmployeeController;

//Personal
use App\Http\Controllers\User\UserController;

//Student
use App\Http\Controllers\Student\StudentController;




Route::prefix('v1')->group(function () {

    Route::get('status', function () {
        return response()->json(['status' => 'API V1 is alive!'], 200);
    });

    Route::post('/login/user', [AuthController::class, 'loginUser']);
    Route::post('/login/student', [AuthController::class, 'loginStudent']);
    Route::post('/login/admin', [AuthController::class, 'loginEmployee']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/check-token', [AuthController::class, 'checkTokenValidity'])->middleware('auth:sanctum');

    Route::get('/plans', [PlanController::class, 'index']);


    Route::post('/register/user', [AuthController::class, 'register']);


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::middleware('user')->group(function () {
            Route::get('/user/dashboard', [UserController::class, 'index']);

            Route::apiResource('/user/users', UserController::class);
        });

        Route::middleware('student')->group(function () {
            Route::get('/student/series', [StudentController::class, 'series']);
        });

        Route::middleware('employee')->group(function () {
            Route::get('/admin/painel', [EmployeeController::class, 'dashboard']);
        });
    });
});
