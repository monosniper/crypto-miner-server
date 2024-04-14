<?php

namespace App\Enums;

enum WithdrawType: string
{
    use BaseEnum;

    case COIN = 'coin';
    case NFT = 'nft';
}
