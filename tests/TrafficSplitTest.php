<?php

namespace tests;

use App\Gateway\ExampleGateway;
use App\Payment\Payment;
use App\TrafficSplit;
use PHPUnit\Framework\TestCase;

class TrafficSplitTest extends TestCase
{
    public function testEqualWeightDistributionOn1000runs()
    {
        $g1 = new ExampleGateway('Gateway1');
        $g2 = new ExampleGateway('Gateway2');
        $g3 = new ExampleGateway('Gateway3');
        $g4 = new ExampleGateway('Gateway4');

        $gateways = [
            ['gateway' => $g1, 'weight' => 25],
            ['gateway' => $g2, 'weight' => 25],
            ['gateway' => $g3, 'weight' => 25],
            ['gateway' => $g4, 'weight' => 25],
        ];

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 1000; $i++) {
            $splitter->handlePayment(new Payment(100));
        }

        print_r('Equal weight distribution (1000 runs): ' . PHP_EOL);
        foreach ($gateways as $entry) {
            $gateway = $entry['gateway'];
            print_r($gateway->getName() . ': ' . $gateway->getTrafficLoad() . PHP_EOL);
            $this->assertGreaterThan(200, $gateway->getTrafficLoad());
        }
    }

    public function testEqualWeightDistributionOn100runs()
    {
        $g1 = new ExampleGateway('Gateway1');
        $g2 = new ExampleGateway('Gateway2');
        $g3 = new ExampleGateway('Gateway3');
        $g4 = new ExampleGateway('Gateway4');

        $gateways = [
            ['gateway' => $g1, 'weight' => 25],
            ['gateway' => $g2, 'weight' => 25],
            ['gateway' => $g3, 'weight' => 25],
            ['gateway' => $g4, 'weight' => 25],
        ];

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 100; $i++) {
            $splitter->handlePayment(new Payment(100));
        }

        print_r('Equal weight distribution (100 runs): ' . PHP_EOL);
        foreach ($gateways as $entry) {
            $gateway = $entry['gateway'];
            print_r($gateway->getName() . ': ' . $gateway->getTrafficLoad() . PHP_EOL);
            $this->assertGreaterThan(5, $gateway->getTrafficLoad());
        }
    }

    public function testCustomWeightDistributionOn1000runs()
    {
        $g1 = new ExampleGateway('Gateway1');
        $g2 = new ExampleGateway('Gateway2');
        $g3 = new ExampleGateway('Gateway3');

        $gateways = [
            ['gateway' => $g1, 'weight' => 75],
            ['gateway' => $g2, 'weight' => 10],
            ['gateway' => $g3, 'weight' => 15],
        ];

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 1000; $i++) {
            $splitter->handlePayment(new Payment(100));
        }

        print_r('Custom weight distribution (1000 runs): ' . PHP_EOL);
        foreach ($gateways as $entry) {
            $gateway = $entry['gateway'];
            print_r($gateway->getName() . ': ' . $gateway->getTrafficLoad() . PHP_EOL);
        }

        $this->assertGreaterThan($g2->getTrafficLoad(), $g3->getTrafficLoad());
        $this->assertGreaterThan($g3->getTrafficLoad(), $g1->getTrafficLoad());
    }

    public function testCustomWeightDistributionOn100runs()
    {
        $g1 = new ExampleGateway('Gateway1');
        $g2 = new ExampleGateway('Gateway2');
        $g3 = new ExampleGateway('Gateway3');

        $gateways = [
            ['gateway' => $g1, 'weight' => 75],
            ['gateway' => $g2, 'weight' => 10],
            ['gateway' => $g3, 'weight' => 15],
        ];

        $splitter = new TrafficSplit($gateways);

        for ($i = 0; $i < 100; $i++) {
            $splitter->handlePayment(new Payment(100));
        }

        print_r('Custom weight distribution (100 runs): ' . PHP_EOL);
        foreach ($gateways as $entry) {
            $gateway = $entry['gateway'];
            print_r($gateway->getName() . ': ' . $gateway->getTrafficLoad() . PHP_EOL);
        }

        $this->assertGreaterThan($g2->getTrafficLoad(), $g3->getTrafficLoad());
        $this->assertGreaterThan($g3->getTrafficLoad(), $g1->getTrafficLoad());
    }
}