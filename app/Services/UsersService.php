<?php

namespace App\Services;

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class UsersService
{
    protected UsersController $controller;

    public function __construct(UsersController $controller)
    {
        $this->controller = $controller;
    }

    public function getAllUsers(Request $request): LengthAwarePaginator
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);

        $users = $this->controller->getAllUsers($page, $pageSize);

        return $users;
    }

    public function postUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'age' => ['required', 'integer'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation failed',
                'errors' => $validator->errors(),
                'error' => true
            ], 422);
        }

        $validated = $validator->validated();

        if ($validated['password'] !== $request->input('password_confirmation')) {
            return response()->json(
                ['msg' => 'Password confirmation does not match.', 'error' => true],
                422
            );
        }

        $user = $this->controller->createUser($validated);

        if (!$user) {
            return response()->json(['error' => 'User creation failed.'], 422);
        }

        return response()->json(
            ['msg' => 'User created successfully.', 'error' => false],
            200
        );
    }
}
