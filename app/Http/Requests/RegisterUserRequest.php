<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'unique:users,name'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'password' => ['required'],
            'phone' => ['required', 'unique:users,phone'],
            'ref_code' => ['exists:refs,code'],
            'connect' => ['nullable'],
        ];
    }
}
