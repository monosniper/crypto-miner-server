<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function getCheckoutUrl(): string;
}
