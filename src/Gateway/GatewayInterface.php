<?php

namespace App\Gateway;

use App\Payment\Payment;

interface GatewayInterface
{
    public function handle(Payment $payment): bool;
    public function getTrafficLoad(): int;
    public function getName(): string;
}
