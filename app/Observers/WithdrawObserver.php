<?php

namespace App\Observers;

use App\Models\Withdraw;
use App\Services\CacheService;

class WithdrawObserver
{
    public function cache(Withdraw $withdraw): void
    {
        CacheService::saveForUser(CacheService::WITHDRAWS, $withdraw->user_id, $withdraw->user->withdraws);
    }

    public function updated(Withdraw $withdraw): void
    {
        $this->cache($withdraw);
    }

    public function created(Withdraw $withdraw): void
    {
        $this->cache($withdraw);
    }

    public function deleted(Withdraw $withdraw): void
    {
        $this->cache($withdraw);
    }
}
