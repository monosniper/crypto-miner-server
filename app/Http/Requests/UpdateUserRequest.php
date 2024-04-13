<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'coin_positions' => ['array'],
            'name' => ['string', 'unique:users,name,'.auth()->id()],
            'first_name' => ['string'],
            'last_name' => ['string'],
            'phone' => ['string', 'unique:users,phone,'.auth()->id()],
            'email' => ['string', 'email', 'unique:users,email,'.auth()->id()],
        ];
    }
}
