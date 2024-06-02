<?php

use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;

return [
    'types' => [
        OrderType::DONATE->value => 'Партнерство',
        OrderType::PURCHASE->value => 'Покупка',
    ],
    'methods' => [
        OrderMethod::CRYPTO->value => 'Криптовалюта',
        OrderMethod::CARD->value => 'Карта',
    ],
    'purchase_types' => [
        OrderPurchaseType::BALANCE->value => 'Баланс',
        OrderPurchaseType::SERVER->value => 'Сервер',
    ],
    'statuses' => [
        OrderStatus::COMPLETED->value => 'Оплачено',
        OrderStatus::FAILED->value => 'Истек срок',
        OrderStatus::PENDING->value => 'Ожидание оплаты',
    ],
];
