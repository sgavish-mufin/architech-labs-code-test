<?php  

class Basket {
    private $products = [];
    private $catalogue;
    private $deliveryRules;
    private $offers;

    public function __construct($catalogue, $deliveryRules, $offers) {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add($productCode) {
        if (!isset($this->catalogue[$productCode])) {
            throw new Exception("Product code {$productCode} not found in catalogue.");
        }
        $this->products[] = $productCode;
    }

    public function total() {
        $subtotal = 0.0;
        $productCounts = array_count_values($this->products);

        // Calculate subtotal and apply offers
        foreach ($productCounts as $productCode => $count) {
            $productPrice = $this->catalogue[$productCode];
            if (isset($this->offers[$productCode])) {
                $offer = $this->offers[$productCode];
                if ($offer['type'] == 'BOGOHP' && $count > 1) {
                    $subtotal += ($count % 2 == 0 ? $count / 2 : ($count - 1) / 2) * ($productPrice * 1.5);
                    $subtotal += ($count % 2 == 1) ? $productPrice : 0;
                } else {
                    $subtotal += $productPrice * $count;
                }
            } else {
                $subtotal += $productPrice * $count;
            }
        }

        // Calculate delivery cost
        $deliveryCost = 0.0;
        foreach ($this->deliveryRules as $rule) {
            if ($subtotal < $rule['threshold']) {
                $deliveryCost = $rule['cost'];
                break;
            }
        }

        return number_format($subtotal + $deliveryCost, 2);
    }
}

// Example usage
$catalogue = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95,
];

$deliveryRules = [
    ['threshold' => 50, 'cost' => 4.95],
    ['threshold' => 90, 'cost' => 2.95],
    ['threshold' => PHP_INT_MAX, 'cost' => 0.00],
];

$offers = [
    'R01' => ['type' => 'BOGOHP'],
];

$basket = new Basket($catalogue, $deliveryRules, $offers);
$basket->add('B01');
$basket->add('G01');
echo "Total: $" . $basket->total() . "\n"; // $37.85

$basket = new Basket($catalogue, $deliveryRules, $offers);
$basket->add('R01');
$basket->add('R01');
echo "Total: $" . $basket->total() . "\n"; // $54.37

$basket = new Basket($catalogue, $deliveryRules, $offers);
$basket->add('R01');
$basket->add('G01');
echo "Total: $" . $basket->total() . "\n"; // $60.85

$basket = new Basket($catalogue, $deliveryRules, $offers);
$basket->add('B01');
$basket->add('B01');
$basket->add('R01');
$basket->add('R01');
$basket->add('R01');
echo "Total: $" . $basket->total() . "\n"; // $98.27

?>