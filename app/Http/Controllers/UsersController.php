<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function getAllUsers($page = 1, $perPage = 10)
    {
        return User::orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
