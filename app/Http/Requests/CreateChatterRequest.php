<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChatterRequest extends FormRequest
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
            'email_address' => 'nullable|email',
            'phone_number' => 'nullable|max:12'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'first_name.required' => 'The First Name field is required',
            'last_name.required' => 'The Last Name field is required',
            'email_address.email' => 'The Email Address field must be a valid email address',
            'phone_number.max' => 'The Phone Number field must not be greater than 12'
        ];

        return $messages;
    }
}
