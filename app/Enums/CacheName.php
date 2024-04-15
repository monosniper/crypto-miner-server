<?php

namespace App\Enums;

enum CacheName: string
{
    case NULL = 'null';
    case PRESETS = 'presets';
    case CONFIGURATION = 'configuration';
    case SESSION = 'session';
    case USER = 'user';
    case USER_REF = 'user_ref';
    case WALLET = 'wallet';
    case NOTIFICATIONS = 'notifications';
    case REPLENISHMENTS = 'replenishments';
    case USER_NFTS = 'user_nfts';
    case USER_SERVERS = 'user_servers';
    case WITHDRAWS = 'withdraws';
    case CONVERTATIONS = 'convertations';
    case ORDERS = 'orders';
    case SERVERS = 'servers';
    case COINS = 'coins';
    case GEO = 'geo';
    case NFTS = 'nfts';
    case ARTICLES = 'articles';
}
