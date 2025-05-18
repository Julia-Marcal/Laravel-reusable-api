<?php

namespace App\Services;

use App\Http\Controllers\UsersController;
use App\Models\User;
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

    public function getUser(string $id): User
    {
        $users = $this->controller->getUserById($id);

        return $users;
    }

    public function deleteUser(string $id): JsonResponse
    {
        $user = $this->controller->deleteUser($id);

        return $user;
    }

}
