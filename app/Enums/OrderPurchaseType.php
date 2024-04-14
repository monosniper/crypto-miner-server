<?php

namespace App\Enums;

enum OrderPurchaseType: string
{
    use BaseEnum;

    case SERVER = 'server';
    case BALANCE = 'balance';
}
