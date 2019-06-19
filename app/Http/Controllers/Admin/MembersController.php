<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    public function getMembers()
    {
        return User::with('phone_numbers', 'email_addresses')->role('Member')->get();
    }
}
