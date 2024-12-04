<?php

use Illuminate\Support\Facades\Route;
use App\src\Teacher\Module\Controllers\ModuleController;

Route::middleware(['auth:sanctum', 'role:Teacher'])->prefix('api/teacher')->group(function () {
//    Route::apiResource('syllabuses', SyllabusController::class);
    Route::apiResource('modules', ModuleController::class);
});
