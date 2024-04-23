<?php

namespace App\Enums;

enum ReportStatus: string
{
    use BaseEnum;

    case SENT = 'sent';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
