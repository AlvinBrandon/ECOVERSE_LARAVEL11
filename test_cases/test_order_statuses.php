<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update one order to delivered status to test
$order = \App\Models\Order::find(4);
if($order) {
    $order->status = 'delivered';
    $order->save();
    echo "Updated order 4 to 'delivered' status\n";
} else {
    echo "Order 4 not found\n";
}

// Update another to pending
$order2 = \App\Models\Order::find(5);
if($order2) {
    $order2->status = 'pending';
    $order2->save();
    echo "Updated order 5 to 'pending' status\n";
} else {
    echo "Order 5 not found\n";
}

echo "Status updates completed. Now the dashboard should show:\n";
echo "- 1 Completed Order (order 4 - delivered)\n";
echo "- 1 Pending Order (order 5 - pending)\n";
echo "- 2 Processing Orders (orders 6,7 - approved)\n";
