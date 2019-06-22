<?php

namespace App\Http\Controllers\Contact;

use App\ContactType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypesController extends Controller
{
    public function getTypes()
    {
        return ContactType::all()->pluck('name');
    }
}
