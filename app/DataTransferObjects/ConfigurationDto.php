<?php

namespace App\DataTransferObjects;

readonly class ConfigurationDto
{
    public function __construct(
        public array $value,
    ) {}

    static public function from(array $data): ConfigurationDto
    {
        return new self(
            value: $data['configuration']['value'],
        );
    }
}
