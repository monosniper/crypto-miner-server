<?php

namespace App\DataTransferObjects;

readonly class FeedbackDto
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
    ) {}

    static public function from(array $data): FeedbackDto
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
            email: $data['email'],
        );
    }
}
