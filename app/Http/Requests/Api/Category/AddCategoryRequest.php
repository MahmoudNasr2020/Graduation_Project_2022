<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','string'],
            'description'=> ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name Required',
            'name.string' => 'Name Must Be String',

        ];
    }
}
