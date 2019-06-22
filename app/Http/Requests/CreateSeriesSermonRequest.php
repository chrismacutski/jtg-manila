<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSeriesSermonRequest extends FormRequest
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
            'sermon_speaker_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image_src' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'sermon_speaker_id.required' => 'The Sermon Name is required',
            'name.required' => 'The Sermon Name is required',
            'description.required' => 'The Sermon Description is required',
            'image_src.required' => 'The Sermon Banner image is required'
        ];

        return $messages;
    }
}
