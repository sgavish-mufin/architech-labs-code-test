# architech-labs-code-test

## Overview

This is a proof of concept for Acme Widget Co's new sales system. It provides a simple interface to manage a shopping basket, calculate totals including special offers, and apply delivery charges based on the total amount spent.

## Products

- **Red Widget (R01):** $32.95
- **Green Widget (G01):** $24.95
- **Blue Widget (B01):** $7.95

## Delivery Charges

- Orders under $50: $4.95
- Orders under $90: $2.95
- Orders of $90 or more: Free delivery

## Special Offers

- Buy one red widget (R01), get the second half price (BOGOHP)

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/acme-widget-co-sales-system.git
    ```

2. Navigate to the project directory:
    ```sh
    cd acme-widget-co-sales-system
    ```

## Usage

To use the basket system, you can create a new `Basket` object and add products by their code. The total cost can be retrieved using the `total` method.

Example usage:

```php
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
----------------