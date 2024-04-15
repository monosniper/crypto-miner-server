<?php

namespace App\Observers;

use App\Models\Ref;
use Exception;

class RefObserver
{
    public function generateCode(): string
    {
        return strtoupper(bin2hex(random_bytes(4)));
    }

    public function created(Ref $ref): void
    {
        $code = $this->generateCode();

        while (Ref::where('code', $code)->exists()) {
            $code = $this->generateCode();
        }

        $ref->update(['code' => $code]);
    }

    public function updated(Ref $ref): void
    {
        //
    }

    public function deleted(Ref $ref): void
    {
        //
    }
}
