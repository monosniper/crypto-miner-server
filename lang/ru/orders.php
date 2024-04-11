<?php

use App\Models\Order;

return [
    'types' => [
        Order::DONATE => 'Партнерство',
        Order::PURCHASE => 'Покупка',
    ],
    'methods' => [
        Order::CRYPTO => 'Криптовалюта',
        Order::CARD => 'Карта',
    ],
    'purchase_types' => [
        Order::BALANCE => 'Баланс',
        Order::SERVER => 'Сервер',
    ],
    'statuses' => [
        Order::COMPLETED => 'Оплачено',
        Order::FAILED => 'Истек срок',
        Order::PENDING => 'Ожидание оплаты',
    ],
];
