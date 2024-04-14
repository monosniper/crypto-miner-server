<?php

namespace App\DataTransferObjects;

class ConvertationDto
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $from_id,
        public readonly int $to_id,
        public readonly int $amount_from,
        public readonly int $amount_to,
    ) {}
}
