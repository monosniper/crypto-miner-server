<?php

namespace App\Enums;

enum OrderMethod: string
{
    use BaseEnum;

    case CRYPTO = 'crypto';
    case CARD = 'card';
}
