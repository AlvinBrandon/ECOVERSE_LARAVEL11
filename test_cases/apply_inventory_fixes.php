<?php

// Apply fixes to correct the inventory bug
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Applying Inventory Fixes ===\n\n";
    
    // 1. Reset inventory #3 to correct quantity (50 pcs)
    echo "1. Resetting inventory #3 to 50 pcs...\n";
    $stmt = $pdo->prepare("UPDATE inventories SET quantity = 50 WHERE id = 3");
    $stmt->execute();
    echo "   ✓ Done\n\n";
    
    // 2. Set Order #62 back to pending since there wasn't enough stock
    echo "2. Setting Order #62 back to pending...\n";
    $stmt = $pdo->prepare("UPDATE orders SET status = 'pending' WHERE id = 62");
    $stmt->execute();
    echo "   ✓ Done\n\n";
    
    // 3. Clean up incorrect stock history entries
    echo "3. Removing incorrect stock history entries...\n";
    $stmt = $pdo->prepare("DELETE FROM stock_histories WHERE note LIKE '%Order #62%'");
    $stmt->execute();
    $deletedRows = $stmt->rowCount();
    echo "   ✓ Deleted {$deletedRows} stock history records\n\n";
    
    // 4. Verify the fixes
    echo "=== Verification ===\n";
    
    // Check current inventory
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) as total
        FROM inventories 
        WHERE product_id = (SELECT id FROM products WHERE name = 'Paperboard cartons')
    ");
    $stmt->execute();
    $newTotal = $stmt->fetchColumn();
    
    echo "Current Paperboard cartons inventory: {$newTotal} pcs\n";
    
    // Check Order #62 status
    $stmt = $pdo->prepare("SELECT status FROM orders WHERE id = 62");
    $stmt->execute();
    $orderStatus = $stmt->fetchColumn();
    
    echo "Order #62 status: {$orderStatus}\n\n";
    
    echo "=== Summary ===\n";
    echo "✓ Fixed inventory calculation bug in SalesApprovalController\n";
    echo "✓ Removed incorrect 'retailer inventory' creation logic\n";
    echo "✓ Reset Paperboard cartons inventory to correct amount\n";
    echo "✓ Set Order #62 back to pending (insufficient stock)\n";
    echo "\nNow when you try to verify Order #62, it should properly show:\n";
    echo "'Insufficient stock available. Only {$newTotal} units in stock, but order requires 607 units.'\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
