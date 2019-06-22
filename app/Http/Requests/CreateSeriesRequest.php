<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSeriesRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'image_src' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'The Series Name is required',
            'description.required' => 'The Series Description is required',
            'image_src.required' => 'The Series Banner image is required'
        ];

        return $messages;
    }
}
