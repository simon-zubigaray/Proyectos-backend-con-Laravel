<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get("/getByStatus/{status}", [TaskController::class, "getByStatus"]);
Route::get("/countByStatus", [TaskController::class, "countByStatus"]);
Route::apiResource("/task", TaskController::class);