<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        return [
            'link' => 'required|string|url|max:255',
            'photo' => 'required',
            'photo_translate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'link.required' => 'Link is required',
            'link.url' => 'Link must be a valid URL',
            'link.max' => 'Link must not be greater than 255 characters',
            'photo.required' => 'Photo is required',
            'photo_translate.required' => 'Photo translate is required',
        ];
    }
}
