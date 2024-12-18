<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'name' => 'required|string|unique:sub_category,name,'.$this->id,
            'category_id' => 'required|exists:categories,id',  // inhert from category
            'icon' => 'required',
            'banner' => 'required',
            // 'status' => 'required|in:active,inactive',
            // 'description' => 'required'
            // 'meta_title' => 'required',
            // 'meta_description' => 'required',
            // 'slug' => 'required|unique:sub_category,slug,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Sub Category Name is required',
            'name.unique' => 'Sub Category Name is already exist',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category is not exist',
            'icon.required' => 'Sub Category Icon is required',
            'banner.required' => 'Sub Category Banner is required',
            // 'status.required' => 'Sub Category Status is required',
            // 'status.in' => 'Sub Category Status is invalid',
            // 'description.required' => 'Sub Category Description is required',
            // 'meta_title.required' => 'Sub Category Meta Title is required',
            // 'meta_description.required' => 'Sub Category Meta Description is required',
            // 'slug.required' => 'Sub Category Slug is required',
            // 'slug.unique' => 'Sub Category Slug is already exist'
        ];
    }
}
