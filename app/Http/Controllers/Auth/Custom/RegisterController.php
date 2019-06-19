<?php

namespace App\Http\Controllers\Auth\Custom;

use App\JTG\Event;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store()
    {
        $this->validate(request(), [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email_address' => ['string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/', 'confirmed']
        ]);

        try {
            /** @var User $user */
            $user = User::create([
                'first_name' => request('first_name'),
                'middle_name' => request('middle_name', NULL),
                'last_name' => request('last_name'),
                'email' => request('email'),
                'username' => request('username'),
                'password' => Hash::make(request('password'))
            ]);

            $user->assignRole('Member');

            $user->attachEmailAddress(request('email_address', ''));
            $user->attachPhoneNumber(request('phone_number', ''));

            $type = request('type', '');
            $modelId = request('model_id', '');

            if ($modelId != '') {
                switch ($type) {
                    case 'event':
                        /** @var Event $event */
                        $event = Event::find($modelId);

                        logger($user);
                        if ($event) {
                            // sign up attendee
                            $event->signUpAttendee($user->id);
                        }

                        return [
                            'success' => true,
                            'user' => $user,
                            'type' => 'event',
                            'data' => $event
                        ];
                        break;
                    default:
                        // silent fail
                        return [
                            'success' => false
                        ];
                        break;
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }
}
