<?php

use App\Enums\Report;

return [
    'statuses' => [
        Report::CALLED->value => 'Звонили',
        Report::NOT_CALLED->value => 'Не звонили',
        Report::NOT_ACCEPTED->value => 'Не ответили',
    ],
];
