<?php

use Illuminate\Support\Facades\Route;
use App\src\Admin\Course\Controllers\CourseController;
use App\src\Admin\Syllabus\Controllers\SyllabusController;
use App\src\Admin\Module\Controllers\ModuleController;

Route::middleware(['auth:sanctum', 'role:Academic Head'])->prefix('academic-head')->group(function () {
    Route::post('/courses/{course}/state', [CourseController::class, 'updateState']);
    Route::apiResource('courses', CourseController::class);

    Route::apiResource('syllabuses', SyllabusController::class);

    Route::post('/modules/{module}/state', [ModuleController::class, 'updateState']);
    Route::apiResource('modules', ModuleController::class);
});