<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'description' => 'required|string|min:10|max:2000',
            'release_date' => 'required|date|before_or_equal:today',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'mainImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
