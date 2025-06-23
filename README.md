# Traffic Split

Utility that routes transactions between multiple payment gateways based on their configured weights.

## Usage example

```
$gateway1 = new ExampleGateway('FirstGatewayName');
$gateway2 = new ExampleGateway('SecondGatewayName');

$gateways = [
['gateway' => $gateway1, 'weight' => 70],
['gateway' => $gateway2, 'weight' => 40]
];

$splitter = new TrafficSplit($gateways);

for ($i = 0; $i < 100; $i++) {
    $payment = new Payment(100.00);
    $splitter->handlePayment($payment);
}

print_r('Traffic distribution' . PHP_EOL);

foreach ([$gateway1, $gateway2] as $gateway) {
    print_r($gateway->getName() . ': ' . $gateway->getTrafficLoad() . PHP_EOL);
}

```


## Instalation

```
composer install
```
## How to test

```
./vendor/bin/phpunit
```

## Requirements

- PHP 8.3 or higher
- Composer