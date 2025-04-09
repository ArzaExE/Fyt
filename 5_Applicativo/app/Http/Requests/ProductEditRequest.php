<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'string|max:255',
            'color' => 'string|max:100',
            'description' => 'string|min:10|max:2000',
            'release_date' => 'date|before_or_equal:today',
            'price' => 'numeric|min:0.01|max:999999.99',
            'mainImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'images' => 'The images can be a maximum of 10',
            'images.*.mimes' => 'Images must be a file of type: jpeg, png, jpg, gif',
        ];
    }
}
