<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\CreateContactRequest;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function store(CreateContactRequest $request)
    {
        try {
            $contact = Contact::addNew(request()->only('first_name', 'last_name', 'email_address', 'phone_number', 'type', 'details'));
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $contact;
    }
}
