<?php

// Clean up incorrect inventory records created by the bug
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Cleaning Up Incorrect Inventory Records ===\n\n";
    
    // Find Paperboard cartons product
    $stmt = $pdo->prepare("SELECT id FROM products WHERE name = 'Paperboard cartons'");
    $stmt->execute();
    $productId = $stmt->fetchColumn();
    
    if (!$productId) {
        echo "Product not found!\n";
        exit;
    }
    
    echo "Paperboard cartons product ID: {$productId}\n\n";
    
    // Get all inventory records for this product
    $stmt = $pdo->prepare("
        SELECT id, quantity, batch_id, created_at, updated_at
        FROM inventories 
        WHERE product_id = ?
        ORDER BY created_at
    ");
    $stmt->execute([$productId]);
    $inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Current inventory records:\n";
    foreach ($inventories as $inv) {
        echo "- Inventory #{$inv['id']}: {$inv['quantity']} pcs (batch: {$inv['batch_id']}) created: {$inv['created_at']}\n";
    }
    
    // The problematic record is inventory #3 with exactly 607 pcs
    // This was created when Order #62 was verified incorrectly
    echo "\nIdentifying problematic records:\n";
    
    // Look for records that were created/updated today and have suspicious quantities
    foreach ($inventories as $inv) {
        $createdToday = strpos($inv['created_at'], '2025-07-22') === 0;
        $updatedToday = strpos($inv['updated_at'], '2025-07-22') === 0;
        
        if ($inv['id'] == 3 && $inv['quantity'] == 607) {
            echo "- Inventory #{$inv['id']} (607 pcs) appears to be incorrectly added from Order #62\n";
            echo "  This should be reverted\n";
        }
    }
    
    // Calculate what the correct total should be
    echo "\n=== Correction Plan ===\n";
    echo "Before the bug:\n";
    echo "- Inventory #3: 50 pcs (original)\n";  
    echo "- Inventory #28: 90 pcs\n";
    echo "- Total: 140 pcs\n\n";
    
    echo "Order #62 for 607 pcs should have:\n";
    echo "- Deducted 607 from available stock\n";
    echo "- But since only 140 was available, it should have failed\n";
    echo "- Instead, it incorrectly added 607 pcs\n\n";
    
    echo "Proposed fix:\n";
    echo "1. Reset inventory #3 to original quantity (50 pcs)\n";
    echo "2. Remove any incorrectly created inventory records\n";
    echo "3. Set Order #62 back to pending status since there wasn't enough stock\n\n";
    
    // Show what needs to be done
    echo "SQL commands to fix:\n";
    echo "UPDATE inventories SET quantity = 50 WHERE id = 3;\n";
    echo "UPDATE orders SET status = 'pending' WHERE id = 62;\n";
    echo "DELETE FROM stock_histories WHERE note LIKE '%Order #62%';\n";
    
    echo "\nDo you want me to apply these fixes? (This will correct the inventory)\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
