<?php

namespace App\Http\Requests;

use App\Models\ConfigurationField;
use App\Models\Order;
use App\Rules\KeysIn;
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
            'type' => [
                'string',
                'in:'.implode(',', Order::TYPES)
            ],
            'method' => [
                'string',
                'in:'.implode(',', Order::METHODS)
            ],
            'purchase_type' => [
                'string',
                'in:'.implode(',', Order::PURCHASE_TYPES)
            ],
            'amount' => [
                'required_if:type,'.Order::DONATE,
                'required_if:purchase_type,'.Order::BALANCE,
                'min:1',
                'numeric'
            ],
            'configuration' => [
                'exclude_with:purchase_id',
                'required_if:purchase_type,'.Order::SERVER,
                'array',
                new KeysIn(ConfigurationField::pluck('slug')->toArray())
            ],
            'configuration.*' => [
                'exists:configuration_options,title',
            ],
            'purchase_id' => [
                'required_if:type,'.Order::PURCHASE,
                'required_if:purchase_type,'.Order::SERVER,
                'exclude_with:configuration',
                'exists:presets,id',
            ],
        ];
    }
}
