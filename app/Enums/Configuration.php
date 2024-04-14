<?php

namespace App\Enums;

enum Configuration : string
{
    use BaseEnum;

    case SELECT = 'select';
    case TEXT = 'text';
    case COINS = 'coins';
    case COMMENT = 'comment';
}
