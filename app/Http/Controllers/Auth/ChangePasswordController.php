<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword()
    {
        $user = auth()->user();

        return view('auth.passwords.change', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $credentials = [
            'email' => auth()->user()->email,
            'password' => $request->input('old_password'),
        ];

        if (! auth()->once($credentials)) {
            return back()->withErrors([
                'old_password' => 'Incorrect Current Password',
            ]);
        }

        $user = User::find(auth()->user()->id);

        $rules = [
            'old_password' => 'required',
            'password' =>  'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/|confirmed'
        ];

        $messages = [
            'password.regex' => 'The Password must contain a number, one uppercase and special character and must be of 8 characters',
            'password.max'    => 'The Password must contain a number, one uppercase and special character and must be of 8 characters'
        ];

        $this->validate($request,$rules, $messages);

        if(Hash::check(request('old_password'), $user->password))
        {
            $user->password = Hash::make(request('password'));
            $user->save();

            return redirect('/backend');
        }
    }
}
