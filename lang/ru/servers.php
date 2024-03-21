<?php

use App\Models\Server;

return [
    'statuses' => [
        Server::ACTIVE_STATUS => 'Активен',
        Server::WORK_STATUS => 'В работе',
        Server::NOT_ACTIVE_STATUS => 'Не активен',
        Server::RELOAD_STATUS => 'Перезагрузка',
    ],
];
