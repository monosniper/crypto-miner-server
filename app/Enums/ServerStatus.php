<?php

namespace App\Enums;

enum ServerStatus: string
{
    use BaseEnum;

    case WORK = 'work';
    case IDLE = 'idle';
}
