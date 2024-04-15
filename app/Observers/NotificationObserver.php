<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Notification;
use App\Services\CacheService;

class NotificationObserver
{
    public function cache(Notification $notification): void
    {
        foreach ($notification->users as $user) {
            CacheService::saveForUser(CacheName::NOTIFICATIONS, $user->id, $user->notifications);
        }
    }

    public function updated(Notification $notification): void
    {
        $this->cache($notification);
    }

    public function created(Notification $notification): void
    {
        $this->cache($notification);
    }

    public function deleted(Notification $notification): void
    {
        $this->cache($notification);
    }
}
