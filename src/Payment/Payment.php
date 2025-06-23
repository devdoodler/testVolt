<?php

declare(strict_types=1);

namespace App\Payment;

readonly class Payment
{
    public function __construct(private float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
