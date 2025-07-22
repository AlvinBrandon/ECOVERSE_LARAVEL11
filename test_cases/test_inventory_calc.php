<?php

// Test the fixed inventory calculation
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Testing Inventory Calculation ===\n\n";
    
    // Get retailer john
    $stmt = $pdo->prepare("SELECT id FROM users WHERE name = 'john' AND role = 'retailer'");
    $stmt->execute();
    $retailer = $stmt->fetch(PDO::FETCH_ASSOC);
    $retailerId = $retailer['id'];
    
    // Get Corrugated cardboard product (the one with wholesaler orders)
    $stmt = $pdo->prepare("SELECT id, name, seller_role FROM products WHERE name = 'Corrugated cardboard'");
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo "Corrugated cardboard product not found!\n";
        exit;
    }
    
    echo "Testing product: {$product['name']} (seller_role: {$product['seller_role']})\n\n";
    
    // Calculate purchased quantity (retailer's orders for this product)
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) as total_purchased
        FROM orders 
        WHERE user_id = ? AND product_id = ? AND status = 'approved'
    ");
    $stmt->execute([$retailerId, $product['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $purchased = $result['total_purchased'] ?? 0;
    
    echo "Purchased by retailer: {$purchased} pcs\n";
    
    // Calculate sold quantity (customer orders for this product)
    $stmt = $pdo->prepare("
        SELECT SUM(o.quantity) as total_sold
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.product_id = ? AND o.status = 'approved' 
        AND (u.role = 'customer' OR u.role_as = 0)
    ");
    $stmt->execute([$product['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $sold = $result['total_sold'] ?? 0;
    
    echo "Sold to customers: {$sold} pcs\n";
    echo "Current inventory: " . ($purchased - $sold) . " pcs\n\n";
    
    echo "This should now show correctly in the retailer inventory!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
