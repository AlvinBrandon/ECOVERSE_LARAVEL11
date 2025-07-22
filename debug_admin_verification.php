<?php

// Debug admin sales verification for wholesaler orders
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Admin Sales Verification Debug ===\n\n";
    
    // Check pending orders from wholesalers
    echo "Pending orders from wholesalers:\n";
    $stmt = $pdo->prepare("
        SELECT o.id, o.quantity, o.status, o.created_at,
               u.name as user_name, u.role, u.role_as,
               p.name as product_name, p.seller_role
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN products p ON o.product_id = p.id
        WHERE o.status = 'pending' 
        AND (u.role = 'wholesaler' OR u.role_as = 5)
        ORDER BY o.created_at DESC
        LIMIT 10
    ");
    $stmt->execute();
    $pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($pendingOrders)) {
        echo "NO PENDING WHOLESALER ORDERS FOUND!\n";
        echo "This might be why you're not seeing any action when trying to verify.\n\n";
        
        // Check if there are any orders at all from wholesalers
        echo "All orders from wholesalers (any status):\n";
        $stmt = $pdo->prepare("
            SELECT o.id, o.quantity, o.status, o.created_at,
                   u.name as user_name, u.role, u.role_as,
                   p.name as product_name
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN products p ON o.product_id = p.id
            WHERE u.role = 'wholesaler' OR u.role_as = 5
            ORDER BY o.created_at DESC
            LIMIT 5
        ");
        $stmt->execute();
        $allOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($allOrders)) {
            echo "NO WHOLESALER ORDERS EXIST AT ALL!\n";
        } else {
            foreach ($allOrders as $order) {
                echo "Order #{$order['id']}: {$order['quantity']} x {$order['product_name']} - {$order['status']} (by {$order['user_name']})\n";
            }
        }
    } else {
        echo "Found " . count($pendingOrders) . " pending wholesaler orders:\n";
        foreach ($pendingOrders as $order) {
            echo "Order #{$order['id']}: {$order['quantity']} x {$order['product_name']} - {$order['status']} (by {$order['user_name']})\n";
        }
        
        echo "\nThese orders should be visible on the admin verification page.\n";
        
        // Check inventory for the first order's product
        if (!empty($pendingOrders)) {
            $firstOrder = $pendingOrders[0];
            echo "\nChecking inventory for product: {$firstOrder['product_name']}\n";
            
            $stmt = $pdo->prepare("
                SELECT id, quantity, batch_id, created_at
                FROM inventories 
                WHERE product_id = (SELECT id FROM products WHERE name = ?)
            ");
            $stmt->execute([$firstOrder['product_name']]);
            $inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($inventories)) {
                echo "NO INVENTORY FOUND for this product!\n";
                echo "This could cause verification to fail.\n";
            } else {
                echo "Inventory records:\n";
                foreach ($inventories as $inv) {
                    echo "- Inventory ID {$inv['id']}: {$inv['quantity']} units (batch: {$inv['batch_id']})\n";
                }
            }
        }
    }
    
    echo "\n=== End Debug ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
