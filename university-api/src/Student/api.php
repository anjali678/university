<?php

use Illuminate\Support\Facades\Route;
use App\src\Student\Module\Controllers\ModuleController;

Route::middleware(['auth:sanctum', 'role:Student'])->prefix('api/student')->group(function () {
//    Route::apiResource('syllabuses', SyllabusController::class);
    Route::apiResource('modules', ModuleController::class);
});
