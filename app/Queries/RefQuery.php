<?php

namespace App\Queries;

use App\Models\Ref;

class RefQuery
{
    public function __invoke($id) {
        return Ref::where('user_id', $id)->with(['users' => function ($query) {
            return $query->withSum(['orders' => fn($query) => $query->completed()], 'amount');
        }])->first();
    }
}
