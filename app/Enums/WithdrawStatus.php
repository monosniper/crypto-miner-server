<?php

namespace App\Enums;

enum WithdrawStatus: string
{
    use BaseEnum;

    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
