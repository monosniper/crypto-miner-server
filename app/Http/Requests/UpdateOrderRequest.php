<?php

namespace App\Http\Requests;

use App\Enums\OrderMethod;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'method' => [
                'required', 'string', 'in:'.implode(',', OrderMethod::values()),
//                'not_in:'.implode(',', array_filter(fn ($method) $method !== $order->method, Order::METHODS))
            ]
        ];
    }
}
