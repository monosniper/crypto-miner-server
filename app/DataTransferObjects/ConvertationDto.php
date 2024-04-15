<?php

namespace App\DataTransferObjects;

readonly class ConvertationDto
{
    public function __construct(
        public int $user_id,
        public int $from_id,
        public int $to_id,
        public int $amount_from,
        public int $amount_to,
    ) {}
}
