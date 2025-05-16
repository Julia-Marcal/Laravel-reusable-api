<?php

namespace App\Services;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersService
{
    protected UserController $controller;

    public function __construct(UserController $controller)
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


}
