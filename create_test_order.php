<?php

// Create a new test order to verify the fix works in the UI
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Creating Test Order for UI Verification ===\n\n";
    
    // Find brandon (wholesaler) and paperboard cartons
    $stmt = $pdo->prepare("SELECT id FROM users WHERE name = 'brandon' AND role = 'wholesaler'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("SELECT id FROM products WHERE name = 'Paperboard cartons'");
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || !$product) {
        echo "User or product not found!\n";
        exit;
    }
    
    // Create a new test order
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, product_id, quantity, status, created_at, updated_at)
        VALUES (?, ?, ?, 'pending', NOW(), NOW())
    ");
    $stmt->execute([$user['id'], $product['id'], 300]);
    $newOrderId = $pdo->lastInsertId();
    
    echo "Created test order #{$newOrderId}:\n";
    echo "- User: brandon (wholesaler)\n";
    echo "- Product: Paperboard cartons\n";
    echo "- Quantity: 300 units\n";
    echo "- Status: pending\n\n";
    
    // Check current inventory
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) as total 
        FROM inventories 
        WHERE product_id = ?
    ");
    $stmt->execute([$product['id']]);
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Current total inventory: {$inventory['total']} units\n";
    echo "Order requires: 300 units\n";
    echo "Should have sufficient stock: " . ($inventory['total'] >= 300 ? "YES" : "NO") . "\n\n";
    
    echo "Now you can test the admin verification page at:\n";
    echo "http://localhost:8000/admin/sales/verify\n\n";
    echo "The order should appear and verification should work without errors!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
