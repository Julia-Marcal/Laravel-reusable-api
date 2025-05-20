<?php

namespace App\Services;

use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
        $user = Redis::get('user:' . $id);

        if ($user) {
            $userArray = json_decode($user, true);
            $user = new User($userArray);
        } else {
            $user = $this->controller->getUserById($id);
            Redis::set('user:' . $id, json_encode($user));
        }

        return $user;
    }

    public function deleteUser(string $id): JsonResponse
    {
        $user = $this->controller->deleteUser($id);

        return $user;
    }

}
