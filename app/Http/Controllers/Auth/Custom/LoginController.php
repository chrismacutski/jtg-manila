<?php

namespace App\Http\Controllers\Auth\Custom;

use App\JTG\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $this->validate(request(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = request('username');
        $password = request('password');

        $type = request('type', '');
        $modelId = request('model_id', '');

        logger($type . ' ' . $modelId);
        if (Auth::attempt ([
            'username' => $username,
            'password' => $password
        ], request()->filled('remember'))) {
            if ($modelId != '') {
                switch ($type) {
                    case 'event':
                        /** @var Event $event */
                        $event = Event::find($modelId);

                        if ($event) {
                            // sign up attendee
                            $event->signUpAttendee(auth()->user()->id);
                        }

                        return [
                            'success' => true,
                            'user' => auth()->user(),
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
        } else {
            return [
                'success' => false
            ];
        }
    }
}
