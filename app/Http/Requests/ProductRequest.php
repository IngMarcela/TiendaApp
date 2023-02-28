<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9\s]+$/',
            ],
            'size' => [
                'string',
                'required',
                Rule::in(['S', 'M', 'L']),
            ],
            'observation' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\s]+$/',
            ],
            'reference' => 'required',
            'quantity' => [
                'required',
                'numeric'],
            'shipping' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute_required',
            'string' => ':attribute_string',
            'max' => ':attribute_max_50',
            'regex' => ':attribute_regex',
            'numeric' => ':attribute_numeric',
        ];
    }
}
