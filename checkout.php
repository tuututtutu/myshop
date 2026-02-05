<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51SsRYrFzpFefGnR9mFXhlMsonZskm024tmUVAcSJlRfItfMcdeHLSPpkvbdfleYfkNo4N8rpRjIYEdiwOsgfM3Xv00gmU4HkPd');

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
