<?php

namespace App\DataTransferObjects;

use App\Models\Ref;

readonly class RefDto
{
    public function __construct(
        public string $ref_code,
        public int $total_refs,
        public int $total_refs_amount,
    ) {}

    static public function from(Ref $ref): RefDto
    {
        return new self(
            ref_code: $ref->code,
            total_refs: $ref->users->count(),
            total_refs_amount: $ref->totalDonates(),
        );
    }
}
