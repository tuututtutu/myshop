<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51POF9cFyvybDzHL8ITTjWwmKtBA21jwTAzWhTaKnsY2u5K1ve6COn9nwrCs26kx4kZ2RW1qB9M0ovOV3IltunWoJ00HHgH6Qam');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Panier vide']);
    exit;
}

$line_items = [];

foreach ($input as $item) {
    $line_items[] = [
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
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'http://localhost/myshop/success.html',
    'cancel_url' => 'http://localhost/myshop/panier.html',
]);

header('Content-Type: application/json');
echo json_encode(['id' => $session->id]);
