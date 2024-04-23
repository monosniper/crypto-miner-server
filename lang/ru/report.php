<?php

use App\Enums\ReportStatus;

return [
    'statuses' => [
        ReportStatus::SENT->value => 'Отправлен',
        ReportStatus::ACCEPTED->value => 'Принят',
        ReportStatus::REJECTED->value => 'Отклонен',
    ],
    'base' => [
        'hot' => 'Горячая',
        'cold' => 'Холодная',
    ],
];
