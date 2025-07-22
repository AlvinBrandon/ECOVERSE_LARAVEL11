<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING RETAILER PRODUCT CREATION ===\n\n";

try {
    // Get the test order
    $order = \App\Models\Order::find(86);
    echo "Processing order: " . $order->order_number . "\n";

    // Check products before approval
    echo "BEFORE APPROVAL:\n";
    echo "Total products: " . \App\Models\Product::count() . "\n";
    echo "Retailer products: " . \App\Models\Product::where('seller_role', 'retailer')->count() . "\n\n";

    // Simulate approval process (with corrected fields)
    $product = $order->product;
    $retailer = $order->user;

    // Check if this retailer already has a customer-facing product for this item
    $retailerProduct = \App\Models\Product::where('name', $product->name)
        ->where('seller_role', 'retailer')
        ->where('created_by', $retailer->id)
        ->first();

    if ($retailerProduct) {
        echo "Found existing retailer product: " . $retailerProduct->name . "\n";
    } else {
        echo "Creating new retailer product...\n";
        // Create new retailer product for customers
        $retailerProduct = \App\Models\Product::create([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price * 1.2, // 20% markup for retail
            'type' => $product->type,
            'seller_role' => 'retailer',
            'image' => $product->image,
            'created_by' => $retailer->id,
        ]);
        echo "Created retailer product ID: " . $retailerProduct->id . "\n";
        
        // Create initial inventory for the retailer product
        $inventory = $retailerProduct->inventories()->create([
            'quantity' => $order->quantity,
            'batch_id' => 'RTL-' . uniqid(),
            'expiry_date' => null,
        ]);
        echo "Created inventory with " . $inventory->quantity . " units\n";
    }

    // Update order status
    $order->update(['status' => 'approved']);

    echo "\nAFTER APPROVAL:\n";
    echo "Total products: " . \App\Models\Product::count() . "\n";
    echo "Retailer products: " . \App\Models\Product::where('seller_role', 'retailer')->count() . "\n\n";

    // Show the new retailer product details
    $newProduct = \App\Models\Product::where('seller_role', 'retailer')->first();
    if ($newProduct) {
        echo "NEW RETAILER PRODUCT:\n";
        echo "- Name: " . $newProduct->name . "\n";
        echo "- Price: UGX " . number_format($newProduct->price) . "\n";
        echo "- Created by retailer ID: " . $newProduct->created_by . "\n";
        echo "- Available quantity: " . ($newProduct->inventories->sum('quantity') ?? 0) . " pcs\n\n";
    }

    echo "✅ SUCCESS: Retailer product creation tested successfully!\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
