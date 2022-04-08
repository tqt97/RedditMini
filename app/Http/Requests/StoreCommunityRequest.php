<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityRequest extends FormRequest
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
            'name' => 'required|string|min:3|unique:communities',
            'description' => 'required|string|max:500',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Name is required',
    //         'name.max' => 'Name is too long',
    //         'description.required' => 'Description is required',
    //         'description.max' => 'Description is too long',
    //     ];
    // }
}
