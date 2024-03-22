<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorReport extends Model
{
    use HasFactory;

    protected $table = 'operators_reports';

    protected $fillable = [
          'operator_id',
          'user_id',
          'status',
          'comment',
          'amount',
    ];

    const STATUS_CALLED = 'called';
    const STATUS_NOT_CALLED = 'not_called';
    const STATUS_NOT_ACCEPTED = 'not_accepted';

    const REPORT_STATUSES = [
        self::STATUS_CALLED,
        self::STATUS_NOT_CALLED,
        self::STATUS_NOT_ACCEPTED,
    ];
}
