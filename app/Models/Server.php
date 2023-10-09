<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'year_price',
        'nft',
        'isHot',
    ];

    const WORK_STATUS = 'work';
    const ACTIVE_STATUS = 'active';
    const NOT_ACTIVE_STATUS = 'not active';
    const RELOAD_STATUS = 'reload';

    const STATUSES = [
        self::ACTIVE_STATUS, self::WORK_STATUS, self::NOT_ACTIVE_STATUS, self::RELOAD_STATUS,
    ];
}
