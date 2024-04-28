<?php

namespace App\Rules;

use App\Models\ConfigurationOption;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Exists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exclude = [
            'configuration.comment',
            'configuration.location',
            'configuration.coins',
        ];

        if(!in_array($attribute, $exclude)) {
            $values = ConfigurationOption::pluck('title')->toArray();
            if(!array_search($value, $values)) $fail('Value of :attribute is not exists');
        }
    }
}
