<?php

namespace App\Observers;

use App\Models\VerificationCode;

class VerificationCodeObserver
{
    public function generateCode(): string
    {
        return \Faker\Factory::create()->bothify('###?###??##?##???#?###?');
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
