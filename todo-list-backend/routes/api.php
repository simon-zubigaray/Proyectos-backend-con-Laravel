<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware("jwt.auth")->group(function () {
    Route::get('who', [AuthController::class, 'who']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get("/getByStatus/{status}", [TaskController::class, "getByStatus"]);
    Route::get("/countByStatus", [TaskController::class, "countByStatus"]);
    Route::apiResource("/task", TaskController::class);
});