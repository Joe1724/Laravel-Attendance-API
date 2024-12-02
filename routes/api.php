<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [AuthController::class, 'user']);
    Route::middleware('auth:sanctum')->get('users', [UserController::class, 'index']);

    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::post('attendances', [AttendanceController::class, 'store']);
    Route::get('attendances/{attendance}', [AttendanceController::class, 'show']);
    Route::put('attendances/{attendance}', [AttendanceController::class, 'update']);
    Route::delete('attendances/{attendance}', [AttendanceController::class, 'destroy']);
});
