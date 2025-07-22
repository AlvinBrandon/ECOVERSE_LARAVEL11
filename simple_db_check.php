<?php

// Simple test to check database contents without Laravel
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Database Check ===\n\n";
    
    // Check users
    echo "Users in database:\n";
    $stmt = $pdo->query("SELECT id, name, role FROM users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Role: {$row['role']}\n";
    }
    
    echo "\nProducts in database:\n";
    $stmt = $pdo->query("SELECT id, name, seller_role FROM products LIMIT 10");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Seller: {$row['seller_role']}\n";
    }
    
    echo "\nOrders in database:\n";
    $stmt = $pdo->query("SELECT id, user_id, product_id, quantity, status FROM orders LIMIT 10");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Order ID: {$row['id']}, User: {$row['user_id']}, Product: {$row['product_id']}, Qty: {$row['quantity']}, Status: {$row['status']}\n";
    }
    
    // Find retailer john specifically
    echo "\nLooking for retailer 'john':\n";
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE name = 'john' AND role = 'retailer'");
    $stmt->execute();
    $retailer = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($retailer) {
        echo "Found retailer john - ID: {$retailer['id']}\n";
        
        // Check his orders
        echo "\nJohn's orders:\n";
        $stmt = $pdo->prepare("
            SELECT o.id, o.product_id, o.quantity, o.status, p.name, p.seller_role 
            FROM orders o 
            JOIN products p ON o.product_id = p.id 
            WHERE o.user_id = ?
        ");
        $stmt->execute([$retailer['id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($orders)) {
            echo "NO ORDERS FOUND for john!\n";
            echo "This is why purchased quantities show as 0.\n";
        } else {
            foreach ($orders as $order) {
                echo "Order #{$order['id']}: {$order['quantity']} x {$order['name']} (seller: {$order['seller_role']}) - {$order['status']}\n";
            }
        }
    } else {
        echo "Retailer 'john' not found!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
