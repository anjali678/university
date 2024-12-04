<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->get('/api/user', function (Request $request) {
    $user = Auth::user();
    return response()->json([
        'user' => $user,
        'role' => $user->roles->last()->name ?? null,  // The last assigned role
        'permissions' => $user->getAllPermissions()->pluck('name'),  // All permissions of the user
    ]);
});

require base_path('src/Domain/api.php');
require base_path('src/Admin/api.php');
