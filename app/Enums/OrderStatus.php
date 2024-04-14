<?php

namespace App\Enums;

enum OrderStatus: string
{
    use BaseEnum;

    case COMPLETED = 'finished';
    case FAILED = 'failed';
    case PENDING = 'waiting';
}
