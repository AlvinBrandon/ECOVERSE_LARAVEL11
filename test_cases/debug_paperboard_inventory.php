<?php

// Debug Paperboard cartons inventory discrepancy
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Paperboard Cartons Inventory Debug ===\n\n";
    
    // Get Paperboard cartons product info
    $stmt = $pdo->prepare("SELECT id, name, seller_role, price FROM products WHERE name = 'Paperboard cartons'");
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo "Paperboard cartons product not found!\n";
        exit;
    }
    
    echo "Product Info:\n";
    echo "- ID: {$product['id']}\n";
    echo "- Name: {$product['name']}\n";
    echo "- Seller Role: {$product['seller_role']}\n";
    echo "- Price: {$product['price']}\n\n";
    
    // Get ALL inventory records for this product
    echo "All inventory records for Paperboard cartons:\n";
    $stmt = $pdo->prepare("
        SELECT id, quantity, batch_id, created_at, updated_at 
        FROM inventories 
        WHERE product_id = ?
        ORDER BY id
    ");
    $stmt->execute([$product['id']]);
    $inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $totalQuantity = 0;
    foreach ($inventories as $inv) {
        echo "- Inventory #{$inv['id']}: {$inv['quantity']} units (batch: '{$inv['batch_id']}') - Created: {$inv['created_at']}\n";
        $totalQuantity += $inv['quantity'];
    }
    
    echo "\nTotal calculated quantity: {$totalQuantity} units\n";
    echo "Inventory page shows: 3607 units\n";
    echo "Admin verification shows: 50 units\n\n";
    
    // Check what the Laravel ORM would return
    echo "Testing Laravel ORM query (what admin verification uses):\n";
    $stmt = $pdo->prepare("
        SELECT quantity 
        FROM inventories 
        WHERE product_id = ? 
        ORDER BY id ASC 
        LIMIT 1
    ");
    $stmt->execute([$product['id']]);
    $firstInventory = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($firstInventory) {
        echo "First inventory record (what ->first() returns): {$firstInventory['quantity']} units\n";
        echo "This matches the '50 units' error message!\n\n";
    }
    
    // Check the specific order causing the issue
    echo "Checking the pending order:\n";
    $stmt = $pdo->prepare("
        SELECT o.id, o.quantity, o.status, u.name as user_name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.product_id = ? AND o.status = 'pending' AND o.quantity = 607
    ");
    $stmt->execute([$product['id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($order) {
        echo "Found the problematic order:\n";
        echo "- Order ID: {$order['id']}\n";
        echo "- Quantity: {$order['quantity']} units\n";
        echo "- User: {$order['user_name']}\n";
        echo "- Status: {$order['status']}\n\n";
    }
    
    echo "=== PROBLEM IDENTIFIED ===\n";
    echo "The SalesApprovalController is using ->first() which only gets the first inventory record.\n";
    echo "It should sum ALL inventory records for the product!\n";
    echo "First record: {$firstInventory['quantity']} units (insufficient)\n";
    echo "Total available: {$totalQuantity} units (sufficient)\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
