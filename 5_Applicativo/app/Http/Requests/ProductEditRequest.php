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
            'name' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'description' => 'nullable|string|min:10|max:2000',
            'release_date' => 'nullable|date|before_or_equal:today',
            'price' => 'nullable|numeric|min:0.01|max:999999.99',
            'mainImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'images' => 'nullable|max:10',
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
