<?php

namespace App\DataTransferObjects;

use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderType;
use App\Models\Configuration;
use App\Models\Preset;

readonly class OrderDto
{
    public function __construct(
        public OrderMethod|string $method,
        public OrderType|string $type,
        public OrderPurchaseType|string $purchase_type,
        public int $user_id,
        public int $count,
        public ?int $purchase_id,
        public int $amount,
        public ?int $configuration_id,
        public string $description,
    ) {}

    static public function from(Array $data): OrderDto
    {
        $type = $data['type'] ?? OrderType::PURCHASE->value;
        $count = $data['count'] ?? 1;
        $purchase_type = $data['purchase_type'] ?? OrderPurchaseType::SERVER->value;
        $method = $data['method'] ?? OrderMethod::CRYPTO->value;

        switch ($type) {
            case OrderType::PURCHASE->value:
                switch ($purchase_type) {
                    case OrderPurchaseType::SERVER->value:
                        $description = __('transactions.buy_server');

                        if (isset($data['purchase_id'])) {
                            $preset = Preset::find($data['purchase_id']);
                            $amount = $preset->price;
                            $configuration_id = $preset->configuration_id;
                        } else if (isset($data['configuration'])) {
                            $configuration = Configuration::create((array) ConfigurationDto::fromRequest($data));
                            $amount = $configuration->price;
                        }

                        break;
                    case OrderPurchaseType::BALANCE->value:
                        $description = __('transactions.replenishment');
                        $amount = $data['amount'];

                        break;
                }
                break;
            case OrderType::DONATE->value:
                $amount = $data['amount'];
                $description = __('transactions.donate');
                break;
        }

        return new self(
            method: $method,
            type: $type,
            purchase_type: $purchase_type,
            user_id: auth()->id(),
            count: $count,
            purchase_id: $data['purchase_id'] ?? null,
            amount: $amount ?? 0,
            configuration_id: $configuration?->id ?? $configuration_id ?? null,
            description: $description ?? '',
        );
    }
}
