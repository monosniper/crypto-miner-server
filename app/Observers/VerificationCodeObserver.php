<?php

namespace App\Observers;

use App\Models\VerificationCode;
use Faker\Factory;

class VerificationCodeObserver
{
    public function generateCode(): string
    {
        return Factory::create()->bothify('###?###??##?##???#?###?');
    }

    public function created(VerificationCode $code): void
    {
        $code->value = $this->generateCode();
        $succes = $code->save();

        while(!$succes) {
            $code->value = $this->generateCode();
            $succes = $code->save();
        }
    }
}
