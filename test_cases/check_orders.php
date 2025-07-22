<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$orders = \App\Models\Order::where('user_id', 12)->get();

echo "Checking order statuses for user 12:\n";
foreach($orders as $order) {
    echo "Order ID: {$order->id}, Status: {$order->status}, Total Price: {$order->total_price}\n";
}

$totalSpent = $orders->sum('total_price');
echo "Total spent across all orders: {$totalSpent}\n";
