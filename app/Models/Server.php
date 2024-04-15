<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'configuration_id',
        'user_id',
    ];

    const WORK_STATUS = 'work';
    const ACTIVE_STATUS = 'active';
    const NOT_ACTIVE_STATUS = 'not active';
    const RELOAD_STATUS = 'reload';

    const STATUSES = [
        self::ACTIVE_STATUS, self::WORK_STATUS, self::NOT_ACTIVE_STATUS, self::RELOAD_STATUS,
    ];

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }
}
