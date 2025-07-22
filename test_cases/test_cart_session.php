<?php
// Test cart session functionality
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create('/cart', 'GET');
$response = $kernel->handle($request);

echo "Cart route test:\n";
echo "Status: " . $response->getStatusCode() . "\n";

// Test cart controller directly
$controller = new App\Http\Controllers\CartController();

// Check if session is working
session_start();
$_SESSION['cart'] = [
    '1' => [
        'product_id' => 1,
        'name' => 'Test Product',
        'price' => 1000,
        'quantity' => 2,
        'stock' => 50
    ]
];

echo "Session cart test:\n";
echo "Cart items: " . count($_SESSION['cart']) . "\n";
echo "Test product: " . $_SESSION['cart']['1']['name'] . "\n";

$kernel->terminate($request, $response);
