<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;

class PricesQuery
{
    public function __invoke($titles, $field_ids): array
    {
        $title_placeholder = implode(",", array_fill(0, count($titles), '?'));
        $field_ids_placeholder = implode(",", array_fill(0, count($field_ids), '?'));

        $query = "select c.price, f.slug
                    from configuration_options c
                        join configuration_fields f on f.id = c.field_id
                    where c.title in ($title_placeholder)
                      and c.field_id in ($field_ids_placeholder)";

        return DB::select($query, [...$titles, ...$field_ids]);
    }
}
