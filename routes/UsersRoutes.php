<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\UsersService;

Route::prefix('users')->group(function () {
    Route::get('/', function (Request $request, UsersService $userService) {
        return $userService->getAllUsers($request);
    });
    Route::get('/{id}', function (string $id, UsersService $userService) {
        return $userService->getUser($id);
    });
    Route::delete('/{id}', function (string $id, UsersService $userService) {
        return $userService->deleteUser($id);
    });
});
