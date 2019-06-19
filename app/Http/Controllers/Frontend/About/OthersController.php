<?php

namespace App\Http\Controllers\Frontend\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OthersController extends Controller
{
    public function index()
    {
        return view('frontend.others');
    }
}
