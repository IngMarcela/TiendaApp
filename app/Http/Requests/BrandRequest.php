<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute_required',
            'max' => ':attribute_max',
        ];
    }
}
