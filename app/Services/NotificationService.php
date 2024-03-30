<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;

class NotificationService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $notifications = auth()->user()->notifications()->latest()->get();

        return NotificationResource::collection($notifications);
    }
}
