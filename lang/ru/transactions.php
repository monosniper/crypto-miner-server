<?php

use App\Models\Transaction;

return [
    'types' => [
        Transaction::DONATE => 'Партнерство',
        Transaction::PURCHASE => 'Покупка',
    ],
    'purchase_types' => [
        Transaction::SERVER => 'Сервер',
        Transaction::BALANCE => 'Баланс',
    ],
    'statuses' => [
        Transaction::COMPLETED => 'Успешно',
        Transaction::FAILED => 'Отмена',
        Transaction::PENDING => 'Ожидание',
    ],
    'replenishment' => 'Пополнение баланса',
    'donate' => 'Партнертство',
    'buy_server' => 'Покупка сервера',
    'renew_server' => 'Продление сервера',
];
