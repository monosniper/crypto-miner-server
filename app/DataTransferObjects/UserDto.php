<?php

namespace App\DataTransferObjects;

use App\Models\User;

readonly class UserDto
{
    public function __construct(
        public int $id,
        public int $session_count,
        public string $name,
        public string $email,
        public string $token,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $phone,
        public ?string $country_code,
        public bool $isVerificated,
        public ?array $coin_positions,
    ) {}

    static public function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            session_count: $user->session_count,
            name: $user->name,
            email: $user->email,
            token: $user->token,
            first_name: $user->first_name,
            last_name: $user->last_name,
            phone: $user->phone,
            country_code: $user->country_code,
            isVerificated: $user->isVerificated,
            coin_positions: $user->coin_positions,
        );
    }
}
