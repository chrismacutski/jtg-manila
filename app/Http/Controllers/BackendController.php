<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            return view('admin.index');
        }

        if (auth()->user()->hasRole('Member')) {
            return view('members.show');
        }

        abort(403);
    }
}
