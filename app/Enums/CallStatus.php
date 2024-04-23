<?php

namespace App\Enums;

enum CallStatus: string
{
    use BaseEnum;

    case CALLED = 'called';
    case NOT_CALLED = 'not_called';
    case NOT_ACCEPTED = 'not_accepted';
}
