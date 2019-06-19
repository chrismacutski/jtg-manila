<?php

namespace App\Http\Controllers\Frontend\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function index()
    {
        return view('frontend.history');
    }
}
