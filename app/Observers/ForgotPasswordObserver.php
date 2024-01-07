<?php

namespace App\Observers;

use App\Models\ForgotPasswordCode;

class ForgotPasswordObserver
{
    public function generateCode(): string
    {
        return \Faker\Factory::create()->bothify('###?###??##?##???#?###?');
    }

    public function created(ForgotPasswordCode $code): void
    {
        $code->value = $this->generateCode();
        $succes = $code->save();

        while(!$succes) {
            $code->value = $this->generateCode();
            $succes = $code->save();
        }
    }
}
