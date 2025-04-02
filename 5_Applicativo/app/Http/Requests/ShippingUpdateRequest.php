<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ShippingUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required','string','max:255']
        ];
    }

}
