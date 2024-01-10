<?php

namespace App\Observers;

use App\Models\Ref;
use Exception;

class RefObserver
{
    /**
     * @throws Exception
     */
    public function generateCode(): string
    {
        return strtoupper(bin2hex(random_bytes(4)));
    }

    /**
     * Handle the Ref "created" event.
     * @throws Exception
     */
    public function created(Ref $ref): void
    {
        $code = $this->generateCode();

        while (Ref::where('code', $code)->exists()) {
            $code = $this->generateCode();
        }

        $ref->update(['code' => $code]);
    }

    /**
     * Handle the Ref "updated" event.
     */
    public function updated(Ref $ref): void
    {
        //
    }

    /**
     * Handle the Ref "deleted" event.
     */
    public function deleted(Ref $ref): void
    {
        //
    }

    /**
     * Handle the Ref "restored" event.
     */
    public function restored(Ref $ref): void
    {
        //
    }

    /**
     * Handle the Ref "force deleted" event.
     */
    public function forceDeleted(Ref $ref): void
    {
        //
    }
}
