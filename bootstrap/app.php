<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\UsersService;

Route::middleware('api')->prefix('users')->group(function () {
    Route::get('/', function (Request $request, UsersService $userService) {
        return $userService->getAllUsers($request);
    });
    Route::post('/', function (Request $request, UsersService $userService) {
        return $userService->postUser($request);
    });
});
