<?php

use App\Models\OperatorReport;

return [
    'statuses' => [
        OperatorReport::STATUS_CALLED => 'Звонили',
        OperatorReport::STATUS_NOT_CALLED => 'Не звонили',
        OperatorReport::STATUS_NOT_ACCEPTED => 'Не ответили',
    ],
];
