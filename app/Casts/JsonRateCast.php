<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonRateCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        $array = (array) json_decode($value);

        return array_map(fn($val) => round(floatval($val) / 100000000, precision: 10), $array);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        $array = array_map(fn($val) => round(floatval($val) * 100000000), $value);

        return json_encode($array);
    }
}
