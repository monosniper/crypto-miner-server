<?php

namespace App\Observers;

use App\Enums\ReportStatus;
use App\Models\Report;

class ReportObserver
{
    public function update(Report $report): void
    {
        if($report->status === ReportStatus::ACCEPTED) {
            $report->calls()->each->update([
                'isHot' => false,
                'operator_id' => null,
                'isNew' => false,
            ]);
        }
    }
}
