<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'image_src' => 'required',
//            'image_thumbnail_src' => 'required',
            'starting_at' => 'required|date_format:Y-m-d H:i:s',
            'ending_at' => 'required|date_format:Y-m-d H:i:s|after_or_equal:starting_at',
            'header_text' => 'required',
            'text_content' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'The Event Name is required',
            'description.required' => 'The Event Description is required',
            'image_src.required' => 'The Event Banner image is required',
            'image_thumbnail_src.required' => 'The Event Thumbnail image is required',
            'starting_at.required' => 'The Starting At field is required',
            'starting_at.date_format' => 'The Starting At field format must be Y-m-d H:i:s',
            'ending_at.required' => 'The Ending At field is required',
            'ending_at.date_format' => 'The Ending At field format must be Y-m-d H:i:s',
            'ending_at.after_or_equal' => 'The Ending At field must be after or equal to Starting At field',
            'header_text.required' => 'The Event Content Heading is required',
            'text_content.required' => 'The Event Text Content is required',

        ];

        return $messages;
    }
}
