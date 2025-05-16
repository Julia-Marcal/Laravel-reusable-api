<?php

use Illuminate\Support\Facades\Route;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line

Route::prefix('users')->group(function () {
    Route::get('/', function (Request $request, UsersService $userService) {
        Log::info('Fetching all users'); // Corrected logging
        return $userService->getAllUsers($request);
    });
});
