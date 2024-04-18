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
        public OrderMethod $method,
        public OrderType $type,
        public OrderPurchaseType $purchase_type,
        public int $user_id,
        public ?int $purchase_id,
        public int $amount,
        public ?int $configuration_id,
        public string $description,
    ) {}

    static public function from(Array $data): OrderDto
    {
        $type = $data['type'] ?? OrderType::PURCHASE;
        $purchase_type = $data['purchase_type'] ?? OrderPurchaseType::SERVER;
        $method = $data['method'] ?? OrderMethod::CRYPTO;

        switch ($type) {
            case OrderType::PURCHASE:
                switch ($purchase_type) {
                    case OrderPurchaseType::SERVER:
                        $description = __('transactions.buy_server');

                        if (isset($data['purchase_id'])) {
                            $preset = Preset::find($data['purchase_id']);
                            $amount = $preset->price;
                            $configuration_id = $preset->configuration_id;
                        } else if (isset($data['configuration'])) {
                            $configuration = Configuration::create(ConfigurationDto::from($data));
                            $amount = $configuration->price;
                        }

                        break;
                    case OrderPurchaseType::BALANCE:
                        $description = __('transactions.replenishment');
                        $amount = $data['amount'];

                        break;
                }
                break;
            case OrderType::DONATE:
                $amount = $data['amount'];
                $description = __('transactions.donate');
                break;
        }

        return new self(
            method: $method,
            type: $type,
            purchase_type: $purchase_type,
            user_id: auth()->id(),
            purchase_id: $data['purchase_id'],
            amount: $amount ?? 0,
            configuration_id: $configuration?->id ?? $configuration_id ?? null,
            description: $description ?? '',
        );
    }
}
