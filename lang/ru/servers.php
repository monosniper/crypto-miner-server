<?php

use App\Models\Server;

return [
    'statuses' => [
        Server::ACTIVE_STATUS => 'Оплачен',
        Server::WORK_STATUS => 'В работе',
        Server::NOT_ACTIVE_STATUS => 'Не оплачен',
        Server::RELOAD_STATUS => 'Перезагрузка',
    ],
];
