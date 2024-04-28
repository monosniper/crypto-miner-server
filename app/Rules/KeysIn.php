<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class KeysIn implements ValidationRule
{
    public function __construct(protected array $values) {}

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedKeys = array_flip($this->values);

        // Compare the value's array *keys* with the flipped fields
        $unknownKeys = array_diff_key($value, $allowedKeys);

        // The validation only passes if there are no unknown keys
        if(count($unknownKeys) !== 0) {
            $fail(':attribute contains invalid fields');
        }
    }
}
