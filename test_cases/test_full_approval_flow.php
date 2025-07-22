<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING FULL RETAILER ORDER APPROVAL FLOW ===\n\n";

try {
    // Get the test order
    $order = \App\Models\Order::find(87);
    echo "Processing order: " . $order->order_number . "\n";
    echo "Product: " . $order->product->name . "\n";
    echo "Quantity: " . $order->quantity . " units\n";
    echo "Retailer: " . $order->user->name . "\n\n";

    // Check customer catalog BEFORE approval
    echo "CUSTOMER CATALOG BEFORE APPROVAL:\n";
    $customerProducts = \App\Models\Product::where('seller_role', 'retailer')->get();
    foreach($customerProducts as $product) {
        $stock = $product->inventories->sum('quantity');
        echo "- " . $product->name . " (Price: UGX " . number_format($product->price) . ", Stock: " . $stock . " pcs)\n";
    }
    echo "Total: " . $customerProducts->count() . " products\n\n";

    // Simulate the SalesApprovalController::approve() method
    $sale = $order;
    $product = $sale->product;
    
    // Check if this retailer already has a customer-facing product for this item
    $retailerProduct = \App\Models\Product::where('name', $product->name)
        ->where('seller_role', 'retailer')
        ->where('created_by', $sale->user->id)
        ->first();
    
    if ($retailerProduct) {
        echo "Found existing retailer product: " . $retailerProduct->name . "\n";
        // Update existing retailer product inventory
        $inventory = $retailerProduct->inventories()->first();
        if ($inventory) {
            $oldQuantity = $inventory->quantity;
            $inventory->quantity += $sale->quantity;
            $inventory->save();
            echo "Updated inventory from " . $oldQuantity . " to " . $inventory->quantity . " units\n";
        } else {
            $inventory = $retailerProduct->inventories()->create([
                'quantity' => $sale->quantity,
                'batch_id' => 'RTL-' . uniqid(),
                'expiry_date' => null,
            ]);
            echo "Created new inventory with " . $inventory->quantity . " units\n";
        }
    } else {
        echo "Creating new retailer product for customers...\n";
        // Create new retailer product for customers
        $retailerProduct = \App\Models\Product::create([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price * 1.2, // 20% markup for retail
            'type' => $product->type,
            'seller_role' => 'retailer',
            'image' => $product->image,
            'created_by' => $sale->user->id,
        ]);
        echo "Created retailer product ID: " . $retailerProduct->id . "\n";
        
        // Create initial inventory for the retailer product
        $inventory = $retailerProduct->inventories()->create([
            'quantity' => $sale->quantity,
            'batch_id' => 'RTL-' . uniqid(),
            'expiry_date' => null,
        ]);
        echo "Created inventory with " . $inventory->quantity . " units\n";
    }
    
    // Update order status
    $sale->status = 'approved';
    $sale->save();
    echo "Order approved!\n\n";

    // Check customer catalog AFTER approval
    echo "CUSTOMER CATALOG AFTER APPROVAL:\n";
    $customerProducts = \App\Models\Product::where('seller_role', 'retailer')->get();
    foreach($customerProducts as $product) {
        $stock = $product->inventories->sum('quantity');
        echo "- " . $product->name . " (Price: UGX " . number_format($product->price) . ", Stock: " . $stock . " pcs)\n";
    }
    echo "Total: " . $customerProducts->count() . " products\n\n";

    echo "✅ SUCCESS: Retailer order approval flow completed successfully!\n";
    echo "✅ Customers can now see and purchase " . $retailerProduct->name . " with " . $inventory->quantity . " units available!\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
