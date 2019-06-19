<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return [
            'data' => $user,
        ];
    }

    public function getUsers()
    {
        return User::getUsers();
    }
}
