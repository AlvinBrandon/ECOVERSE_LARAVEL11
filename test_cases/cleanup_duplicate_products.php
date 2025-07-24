<?php

// Cleanup script to eliminate duplicate retailer products and migrate to owner-based inventory

require 'vendor/autoload.php';

use App\Models\Product;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔄 Starting cleanup of duplicate retailer products...\n";

DB::beginTransaction();

try {
    // Step 1: Find all duplicate retailer products
    $retailerProducts = Product::where('seller_role', 'retailer')->get();
    
    echo "📊 Found " . $retailerProducts->count() . " retailer products to process\n";
    
    foreach ($retailerProducts as $retailerProduct) {
        echo "🔍 Processing: {$retailerProduct->name} (ID: {$retailerProduct->id})\n";
        
        // Find the original wholesaler product with the same name
        $originalProduct = Product::where('name', $retailerProduct->name)
            ->where('seller_role', 'wholesaler')
            ->first();
            
        if (!$originalProduct) {
            echo "⚠️  No original wholesaler product found for {$retailerProduct->name}, skipping...\n";
            continue;
        }
        
        // Get the retailer who created this product
        $retailer = User::find($retailerProduct->created_by);
        if (!$retailer) {
            echo "⚠️  No retailer found for product {$retailerProduct->name}, skipping...\n";
            continue;
        }
        
        // Get existing inventory for the retailer product
        $retailerInventories = $retailerProduct->inventories;
        
        foreach ($retailerInventories as $inventory) {
            echo "📦 Migrating inventory: {$inventory->quantity} units to owner-based system\n";
            
            // Create new owner-based inventory record for the original product
            $originalProduct->inventories()->create([
                'quantity' => $inventory->quantity,
                'batch_id' => $inventory->batch_id,
                'owner_id' => $retailer->id,
                'owner_type' => 'retailer',
                'retail_markup' => 0.20, // Default 20% markup
            ]);
            
            // Delete old inventory record
            $inventory->delete();
        }
        
        // Update any orders that reference the duplicate product to reference the original
        DB::table('orders')
            ->where('product_id', $retailerProduct->id)
            ->update(['product_id' => $originalProduct->id]);
            
        echo "📝 Updated orders to reference original product\n";
        
        // Delete the duplicate retailer product
        $retailerProduct->delete();
        echo "🗑️  Deleted duplicate product: {$retailerProduct->name}\n";
    }
    
    echo "\n✅ Cleanup completed successfully!\n";
    echo "📊 Summary:\n";
    echo "   - Eliminated duplicate retailer products\n";
    echo "   - Migrated inventory to owner-based system\n";
    echo "   - Updated order references\n";
    echo "   - Products now: " . Product::count() . " (should be ~20)\n";
    
    DB::commit();
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error during cleanup: " . $e->getMessage() . "\n";
    echo "🔄 All changes have been rolled back.\n";
}

echo "\n🎉 Cleanup script finished!\n";
