<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVisitorRequest extends FormRequest
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
            'visiting_at' => 'required|date_format:Y-m-d|after_or_equal:today'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email_address.email' => 'The Email Address must be a valid email',
            'email_address.string' => 'The Email Address must be a valid string',
            'visiting_at.required' => 'The Preferred Date and Time of visit is required',
            'visiting_at.date_format' => 'The Preferred Date and Time of visit format must be Y-m-d',
            'visiting_at.after' => 'The Preferred Date and Time of visit must be after or equal today'
        ];

        return $messages;
    }
}
