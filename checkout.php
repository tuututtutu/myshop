<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('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');

$items = json_decode(file_get_contents("php://input"), true);

$lineItems = [];

foreach ($items as $item) {
  $lineItems[] = [
    'price_data' => [
      'currency' => 'eur',
      'product_data' => [
        'name' => $item['name'],
      ],
      'unit_amount' => $item['price'] * 100,
    ],
    'quantity' => 1,
  ];
}

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => $lineItems,
  'mode' => 'payment',
  'success_url' => 'http://localhost/success.html',
  'cancel_url' => 'http://localhost/panier.html',
]);

echo json_encode(['id' => $session->id]);

