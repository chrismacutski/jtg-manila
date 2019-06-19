<?php

namespace App\Http\Controllers\Frontend\About;

use App\AboutContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisionController extends Controller
{
    public function index()
    {
        return view('frontend.vision');
    }
}
