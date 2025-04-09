<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;
        $minAgeDate = now()->subYears(18)->format('Y-m-d');

        return [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($userId),
            ],
            'role' => 'required|string|in:admin,vendor,user',
            'born_date' => 'required|date|before_or_equal:' . $minAgeDate,
            'address' => 'nullable|string|max:255',
            'postcode' => 'nullable|numeric|digits_between:3,10',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            // Controlli sul numero di telefono e provenienza (input apposta)
            // Rimozione di caratteri superflui e salvataggio nel db come +11234556789
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'born_date.before_or_equal' => 'The user must be of legal age.',
        ];
    }
}
