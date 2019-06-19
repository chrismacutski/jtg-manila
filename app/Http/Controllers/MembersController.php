<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->hasRole('Member')) {
            abort(403);
        }

        return view('members.index');
    }

    public function show(User $member)
    {
        if (!auth()->user()->hasRole('Member')) {
            abort(403);
        }

        return view('members.show')
            ->with('member', $member);
    }
}
