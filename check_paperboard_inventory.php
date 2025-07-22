<?php

// Check Paperboard cartons inventory specifically
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Paperboard Cartons Inventory Check ===\n\n";
    
    // Get current inventory for Paperboard cartons
    $stmt = $pdo->prepare("
        SELECT p.id as product_id, p.name,
               i.id as inventory_id, i.quantity, i.batch_id, i.created_at, i.updated_at
        FROM products p
        LEFT JOIN inventories i ON p.id = i.product_id
        WHERE p.name = 'Paperboard cartons'
        ORDER BY i.id
    ");
    $stmt->execute();
    $inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $total = 0;
    echo "Paperboard cartons inventory records:\n";
    foreach ($inventories as $inv) {
        if ($inv['inventory_id']) {
            echo "- Inventory #{$inv['inventory_id']}: {$inv['quantity']} pcs (batch: {$inv['batch_id']})\n";
            echo "  Created: {$inv['created_at']}, Updated: {$inv['updated_at']}\n";
            $total += $inv['quantity'];
        }
    }
    
    echo "\nTotal calculated: {$total} pcs\n\n";
    
    // Check recent orders for this product
    echo "Recent orders for Paperboard cartons:\n";
    $stmt = $pdo->prepare("
        SELECT o.id, o.quantity, o.status, o.created_at, o.updated_at,
               u.name as user_name, u.role
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN products p ON o.product_id = p.id
        WHERE p.name = 'Paperboard cartons'
        ORDER BY o.created_at DESC
        LIMIT 10
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($orders as $order) {
        echo "- Order #{$order['id']}: {$order['quantity']} pcs by {$order['user_name']} ({$order['role']}) - {$order['status']}\n";
        echo "  Created: {$order['created_at']}, Updated: {$order['updated_at']}\n";
    }
    
    // Check if there was a 607 unit order recently
    echo "\nLooking for 607 unit order specifically:\n";
    $stmt = $pdo->prepare("
        SELECT o.id, o.quantity, o.status, o.created_at, o.updated_at,
               u.name as user_name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN products p ON o.product_id = p.id
        WHERE p.name = 'Paperboard cartons' AND o.quantity = 607
        ORDER BY o.created_at DESC
    ");
    $stmt->execute();
    $order607 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($order607)) {
        echo "No 607 unit order found!\n";
        echo "Maybe the order hasn't been placed yet, or it's for a different quantity.\n";
    } else {
        foreach ($order607 as $order) {
            echo "Found 607 unit order:\n";
            echo "- Order #{$order['id']}: {$order['quantity']} pcs by {$order['user_name']} - {$order['status']}\n";
            echo "  Created: {$order['created_at']}, Updated: {$order['updated_at']}\n";
        }
    }
    
    echo "\n=== Math Check ===\n";
    echo "If total was 3607 pcs and 607 were ordered:\n";
    echo "3607 - 607 = " . (3607 - 607) . " pcs (should be remaining)\n";
    echo "But we're seeing: {$total} pcs\n";
    echo "Difference: " . ($total - (3607 - 607)) . " pcs\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
