<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('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');

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

