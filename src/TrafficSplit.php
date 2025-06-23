<?php

declare(strict_types=1);

namespace App;

use App\Gateway\GatewayInterface;
use App\Payment\Payment;

class TrafficSplit
{
    /**
     * @var GatewayInterface[]
     */
    private array $weightMap = [];

    /**
     * @param array<int, array{gateway: GatewayInterface, weight: int}> $gatewaysWithWeights
     */
    public function __construct(array $gatewaysWithWeights)
    {
        $this->validate($gatewaysWithWeights);

        foreach ($gatewaysWithWeights as $gatewayWithWeight) {
            $gateway = $gatewayWithWeight['gateway'];
            $weight = $gatewayWithWeight['weight'];

            for ($i = 0; $i < $weight; $i++) {
                $this->weightMap[] = $gateway;
            }
        }
    }

    public function handlePayment(Payment $payment): bool
    {
        if (empty($this->weightMap)) {
            throw new \RuntimeException('No gateways configured.');
        }

        $selectedGateway = $this->weightMap[random_int(0, count($this->weightMap) - 1)];

        return $selectedGateway->handle($payment);
    }

    private function validate(array $gatewaysWithWeights): void
    {
        foreach ($gatewaysWithWeights as $index => $gatewayWithWeight) {
            if (!is_array($gatewayWithWeight)) {
                throw new \InvalidArgumentException("Entry at index $index must be an array.");
            }

            if (
                !isset($gatewayWithWeight['gateway'])
                || !$gatewayWithWeight['gateway'] instanceof GatewayInterface
            ) {
                throw new \InvalidArgumentException(
                    "Entry at index $index must contain a valid gateway that implements GatewayInterface."
                );
            }

            if (
                !isset($gatewayWithWeight['weight'])
                || !is_int($gatewayWithWeight['weight'])
                || $gatewayWithWeight['weight'] <= 0
            ) {
                throw new \InvalidArgumentException(
                    "Entry at index $index must contain a positive integer 'weight'."
                );
            }
        }
    }
}
