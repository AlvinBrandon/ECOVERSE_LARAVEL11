<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating demo retailer orders...\n";

// Get retailer users
$retailers = User::where('role', 'retailer')->orWhere('role_as', 2)->take(3)->get();
echo "Found " . $retailers->count() . " retailers\n";

// Get products that wholesalers might sell
$products = Product::where('seller_role', 'wholesaler')->orWhereNull('seller_role')->take(10)->get();
echo "Found " . $products->count() . " products\n";

if ($retailers->count() > 0 && $products->count() > 0) {
    // Create some demo orders
    $orderStatuses = ['pending', 'approved', 'rejected'];
    
    for ($i = 0; $i < 15; $i++) {
        $retailer = $retailers->random();
        $product = $products->random();
        $quantity = rand(5, 50); // Bulk quantities for retailer orders
        $status = $orderStatuses[array_rand($orderStatuses)];
        
        $order = Order::create([
            'user_id' => $retailer->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'price' => $product->price,
            'total_price' => $quantity * $product->price,
            'status' => $status,
            'order_number' => 'ORD-RTL-' . date('Ymd') . '-' . (1000 + $i),
            'address' => $retailer->address ?? 'Demo Address for ' . $retailer->name,
            'phone' => $retailer->phone ?? '0700000000',
            'delivery_status' => $status === 'approved' ? ['pending', 'dispatched', 'delivered'][array_rand(['pending', 'dispatched', 'delivered'])] : 'pending',
            'tracking_code' => $status === 'approved' ? 'RTL-' . date('Ymd') . '-' . (1000 + $i) : null,
            'dispatch_log' => $status === 'rejected' ? 'Rejected for demo purposes' : null,
            'verified_at' => $status !== 'pending' ? now()->subDays(rand(1, 10)) : null,
            'verified_by' => $status !== 'pending' ? 1 : null, // Assuming admin user ID 1
            'created_at' => now()->subDays(rand(1, 30)),
            'updated_at' => now()->subDays(rand(0, 5)),
        ]);
        
        echo "Created order #{$order->id} for retailer {$retailer->name} (Status: {$status})\n";
    }
    
    echo "\nDemo retailer orders created successfully!\n";
    echo "You can now test the wholesaler retailer network functionality.\n";
} else {
    echo "Error: Not enough retailers or products found to create demo orders.\n";
    echo "Please ensure you have:\n";
    echo "- At least 1 user with role 'retailer' or role_as = 2\n";
    echo "- At least 1 product in the database\n";
}
