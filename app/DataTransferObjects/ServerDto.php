<?php

namespace App\DataTransferObjects;

use App\Models\Order;

readonly class ServerDto
{
    public function __construct(
        public int $user_id,
        public int $configuration_id,
    ) {}

    static public function fromOrder(Order $order): ServerDto
    {
        return new self(
            user_id: $order->user_id,
            configuration_id: $order->configuration_id,
        );
    }
}
