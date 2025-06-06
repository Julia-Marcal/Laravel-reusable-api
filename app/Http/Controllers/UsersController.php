<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function getAllUsers($page = 1, $perPage = 10)
    {
        $users = User::orderBy('name')->paginate($perPage, ['*'], 'page', $page);
        return UserResource::collection($users);
    }

    public function getUserById($id)
    {
        $user = Redis::get('user:' . $id);

        if ($user) {
            $userArray = json_decode($user, true);
            $user = new User($userArray);
        } else {
            $user = User::find($id);
            Redis::set('user:' . $id, json_encode($user));
        }

        return new UserResource($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['msg' => 'User not found', 'error' => true], 404);
        }

        $user->delete();
        return response()->json(['msg' => 'User deleted successfully', 'error' => false], 200);
    }
}
