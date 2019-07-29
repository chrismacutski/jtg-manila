<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventAttendeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_address' => 'nullable|string|email|',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email_address.email' => 'The Email Address must be a valid email',
            'email_address.string' => 'The Email Address must be a valid string'
        ];

        return $messages;
    }
}
