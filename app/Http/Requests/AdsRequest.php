<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
            'banner' => 'required',
            'english_banner' => 'required',
            'link' => 'required|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required',
            'meta_title' => 'string',
            'meta_description' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter the name of the ad',
            'name.max' => 'The name of the ad cannot be more than 255 characters',
            'banner.required' => 'Please choose the banner of the ad in arabic language',
            'english_banner.required' => 'Please choose the banner of the ad in english language',
            'link.required' => 'Please enter the link of the ad',
            'link.url' => 'Please enter a valid url for the ad',
            'start_date.required' => 'Please enter the start date of the ad',
            'start_date.date' => 'Please enter a valid date for the start date of the ad',
            'end_date.required' => 'Please enter the end date of the ad',
            'end_date.date' => 'Please enter a valid date for the end date of the ad',
            'end_date.after' => 'The end date of the ad must be after the start date',
            'status.required' => 'Please choose the status of the ad',
        ];
    }
}
