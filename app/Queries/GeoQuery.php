<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;

class GeoQuery
{
    public function __invoke(): array
    {
        return DB::select("
                    SELECT country_code, count(country_code) as total FROM users WHERE country_code IS NOT NULL
                    GROUP BY country_code ORDER BY total DESC
                ");
    }
}
