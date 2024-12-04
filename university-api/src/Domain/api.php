<?php

use App\src\Domain\Department\Controllers\DepartmentController;
use App\src\Domain\Faculty\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::get('/faculties', [FacultyController::class, 'index']);
    Route::get('/departments', [DepartmentController::class, 'index']);
});
