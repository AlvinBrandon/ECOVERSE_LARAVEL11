<?php

// Add inventory to fix verification issues
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Adding Inventory for Pending Orders ===\n\n";
    
    // Get pending orders that need more inventory
    $stmt = $pdo->prepare("
        SELECT o.id, o.quantity, o.product_id,
               p.name as product_name,
               COALESCE(i.quantity, 0) as current_stock
        FROM orders o
        JOIN products p ON o.product_id = p.id
        LEFT JOIN inventories i ON p.id = i.product_id
        JOIN users u ON o.user_id = u.id
        WHERE o.status = 'pending' 
        AND (u.role = 'wholesaler' OR u.role_as = 5)
        ORDER BY o.id
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($orders as $order) {
        $needed = $order['quantity'];
        $current = $order['current_stock'];
        $shortage = max(0, $needed - $current);
        
        echo "Order #{$order['id']}: {$order['product_name']}\n";
        echo "  Required: {$needed} units\n";
        echo "  Current stock: {$current} units\n";
        
        if ($shortage > 0) {
            echo "  Shortage: {$shortage} units - ADDING INVENTORY\n";
            
            // Add inventory to cover the shortage plus some extra
            $addAmount = $shortage + 50; // Add extra buffer
            
            // Check if inventory record exists
            $stmt = $pdo->prepare("SELECT id FROM inventories WHERE product_id = ?");
            $stmt->execute([$order['product_id']]);
            $inventoryExists = $stmt->fetch();
            
            if ($inventoryExists) {
                // Update existing inventory
                $stmt = $pdo->prepare("
                    UPDATE inventories 
                    SET quantity = quantity + ? 
                    WHERE product_id = ?
                ");
                $stmt->execute([$addAmount, $order['product_id']]);
                echo "  ✓ Added {$addAmount} units to existing inventory\n";
            } else {
                // Create new inventory record
                $stmt = $pdo->prepare("
                    INSERT INTO inventories (product_id, quantity, batch_id, created_at, updated_at)
                    VALUES (?, ?, ?, NOW(), NOW())
                ");
                $batchId = 'ADMIN-STOCK-' . date('Ymd');
                $stmt->execute([$order['product_id'], $addAmount, $batchId]);
                echo "  ✓ Created new inventory with {$addAmount} units\n";
            }
            
        } else {
            echo "  ✓ Sufficient stock available\n";
        }
        echo "\n";
    }
    
    echo "=== Inventory Update Complete ===\n";
    echo "You should now be able to verify the wholesaler orders!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
