<?php

use App\Enums\CallStatus;

return [
    'statuses' => [
        CallStatus::CALLED->value => 'Звонили',
        CallStatus::NOT_CALLED->value => 'Не звонили',
        CallStatus::NOT_ACCEPTED->value => 'Не ответили',
    ],
];
