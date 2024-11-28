<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logs' => ['required', 'array'],
        ];
    }
}
