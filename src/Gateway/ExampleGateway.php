<?php

namespace App\Gateway;

use App\Payment\Payment;

class ExampleGateway implements GatewayInterface
{
    private string $name;
    private int $load = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function handle(Payment $payment): bool
    {
        $this->load++;

        return true;
    }

    public function getTrafficLoad(): int
    {
        return $this->load;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
