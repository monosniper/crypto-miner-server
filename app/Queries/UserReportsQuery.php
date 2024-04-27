<?php

namespace App\Queries;

use App\Enums\ReportStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserReportsQuery
{
    public function __invoke(): Collection
    {
        return DB::table('users', 'u')
            ->select('u.id')
            ->join('calls', 'calls.user_id',  '=', 'u.id')
            ->join('call_report', 'call_id',  '=', 'calls.id')
            ->join('reports', 'reports.id',  '=', 'call_report.report_id')
            ->where('reports.status', '=', ReportStatus::ACCEPTED)
            ->pluck('id');
    }
}
