<?php

use Illuminate\Support\Facades\Route;
use App\Services\UsersService;
use Illuminate\Http\Request;

Route::prefix('users')->group(function () {
    Route::get('/', function (Request $request, UsersService $userService) {
        return $userService->getAllUsers($request);
    });
});
