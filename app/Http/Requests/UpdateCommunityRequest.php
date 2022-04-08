<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommunityRequest extends FormRequest
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
            // 'name' => 'required|string|max:50|unique:communities,name,' . $this->community->id,
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('communities')->ignore($this->community->id),
            ],
            'description' => 'required|string|max:500',
        ];
    }
}
