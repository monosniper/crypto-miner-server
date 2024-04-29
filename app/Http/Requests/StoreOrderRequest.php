<?php

namespace App\Http\Requests;

use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderType;
use App\Models\ConfigurationField;
use App\Rules\Exists;
use App\Rules\KeysIn;
use Illuminate\Contracts\Validation\Rule;
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
                'in:'.implode(',', OrderType::values())
            ],
            'method' => [
                'string',
                'in:'.implode(',', OrderMethod::values())
            ],
            'purchase_type' => [
                'string',
                'in:'.implode(',', OrderPurchaseType::values())
            ],
            'amount' => [
                'required_if:type,'.OrderType::DONATE->value,
                'required_if:purchase_type,'.OrderPurchaseType::BALANCE->value,
                'min:1',
                'numeric'
            ],
            'configuration' => [
                'exclude_with:purchase_id',
                'required_if:purchase_type,'.OrderPurchaseType::SERVER->value,
                'array',
                new KeysIn(
                    ConfigurationField::whereNot('slug', 'type')
                        ->pluck('slug')->toArray()
                )
            ],
            'configuration.*' => new Exists,
            'configuration.coins' => ['required', 'array'],
            'configuration.coins.*' => 'exists:coins,id',
            'purchase_id' => [
                'exclude_with:configuration',
                'required_if:type,'.OrderType::PURCHASE->value,
                'required_if:purchase_type,'.OrderPurchaseType::SERVER->value,
                'exists:presets,id',
            ],
            'count' => [
                'numeric',
                'min:1',
                'max:24',
            ]
        ];
    }
}
