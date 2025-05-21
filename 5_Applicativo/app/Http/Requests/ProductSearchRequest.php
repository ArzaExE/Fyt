<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'priceRange' => 'nullable|numeric|between:30,500',
            'size' => 'nullable|string|between:35,50',
            'price' => 'nullable|string|in:lowest,highest',
            'dateFilter' => 'nullable|string|in:newest,oldest',
        ];
    }
}
