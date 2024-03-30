<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'type' => ['required', 'string', 'in:'.implode(',', Order::TYPES)],
            'method' => ['required', 'string', 'in:'.implode(',', Order::METHODS)],
            'purchase_type' => ['required_if:type,'.Order::PURCHASE, 'string', 'in:'.implode(',', Order::PURCHASE_TYPES)],

            'amount' => [
                'required_if:purchase_type,'.Order::BALANCE,
                'required_if:type,'.Order::DONATE,
                'exclude_if:purchase_type,'.Order::SERVER,
                'min:1',
                'numeric'
            ],
            'purchase_id' => [
                'required_if:purchase_type,'.Order::SERVER,
                'exists:servers,id',
            ],
        ];
    }
}
