<?php

namespace App\DataTransferObjects;

readonly class ServerLogDto
{
    public function __construct(
        public array $logs,
        public array $founds,
    ) {}

    static public function from(array $data): self
    {
        return new self(
            logs: $data['logs'],
            founds: $data['founds'],
        );
    }
}
