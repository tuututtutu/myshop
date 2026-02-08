<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

require __DIR__ . '/vendor/autoload.php';

\Stripe\Stripe::setApiKey(getenv('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'));

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Panier invalide']);
    exit;
}

$line_items = [];

foreach ($input as $item) {
    if (!isset($item['name'], $item['price'])) continue;

    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $item['name'],
            ],
            'unit_amount' => (int) ($item['price'] * 100),
        ],
        'quantity' => 1,
    ];
}

if (empty($line_items)) {
    http_response_code(400);
    echo json_encode(['error' => 'Panier vide']);
    exit;
}

$session = \Stripe\Checkout\Session::create([
    'mode' => 'payment',
    'line_items' => $line_items,
    'success_url' => 'https://my-shop.shop/success.html',
    'cancel_url' => 'https://my-shop.shop/panier.html',
]);

echo json_encode(['id' => $session->id]);
