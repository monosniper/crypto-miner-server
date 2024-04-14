<?php

namespace App\Enums;

enum OrderType: string
{
    use BaseEnum;

    case PURCHASE = 'purchase';
    case DONATE = 'donate';
}
