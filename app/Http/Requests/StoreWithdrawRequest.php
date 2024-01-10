<?php

namespace App\Http\Requests;

use App\Models\Withdraw;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawRequest extends FormRequest
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
//            'type' => [Rule::in(Withdraw::TYPES), 'sometimes', ],
//            'wallet' => ['required', ],
//            'amount' => ['sometimes', 'numeric', ],
//            'user_id' => ['required', 'exists:users,id', ],
//            'nft_id' => ['sometimes', 'exists:nfts,id', ],
        ];
    }
}
