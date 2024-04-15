<?php

namespace App\Enums;

enum CacheType: string
{
    case DEFAULT = 'default';
    case AUTH = 'auth';
    case SINGLE = 'single';
}
