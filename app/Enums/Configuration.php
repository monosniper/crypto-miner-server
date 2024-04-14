<?php

namespace App\Enums;

enum Configuration: string
{
    case SELECT = 'select';
    case TEXT = 'text';
    case COINS = 'coins';
    case COMMENT = 'comment';
}
