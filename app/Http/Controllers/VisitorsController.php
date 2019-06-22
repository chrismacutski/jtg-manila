<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVisitorRequest;
use App\Visitor;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    public function store(CreateVisitorRequest $request)
    {
        try {
            /** @var Visitor $visitor */
            $visitor = Visitor::addNew(request()->only('first_name', 'last_name', 'phone_number', 'email_address', 'visiting_at'));
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $visitor;
    }
}
