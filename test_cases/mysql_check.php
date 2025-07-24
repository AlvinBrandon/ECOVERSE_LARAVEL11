<?php

// Check MySQL database for retailer orders
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== MySQL Database Check ===\n\n";
    
    // Find retailer john
    echo "Looking for retailer 'john':\n";
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE name = 'john' AND role = 'retailer'");
    $stmt->execute();
    $retailer = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$retailer) {
        echo "Retailer 'john' not found!\n";
        echo "Available users:\n";
        $stmt = $pdo->query("SELECT id, name, role FROM users WHERE role = 'retailer' LIMIT 5");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['name']} (ID: {$row['id']})\n";
        }
        exit;
    }
    
    echo "Found retailer: {$retailer['name']} (ID: {$retailer['id']})\n\n";
    
    // Check all orders by this retailer
    echo "All orders by retailer {$retailer['name']}:\n";
    $stmt = $pdo->prepare("
        SELECT o.id, o.product_id, o.quantity, o.status, o.created_at,
               p.name as product_name, p.seller_role 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([$retailer['id']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($orders)) {
        echo "NO ORDERS FOUND!\n";
        echo "This is why purchased quantities show as 0.\n\n";
        echo "The retailer needs to:\n";
        echo "1. Browse products from wholesalers\n";
        echo "2. Add them to cart and place orders\n";
        echo "3. Have those orders approved\n\n";
        
        // Check if there are any wholesaler products available
        echo "Available wholesaler products:\n";
        $stmt = $pdo->query("SELECT id, name FROM products WHERE seller_role = 'wholesaler' LIMIT 5");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['name']} (ID: {$row['id']})\n";
        }
    } else {
        echo "Total orders: " . count($orders) . "\n\n";
        foreach ($orders as $order) {
            echo "Order #{$order['id']}: {$order['quantity']} x {$order['product_name']}\n";
            echo "  Seller: {$order['seller_role']}\n";
            echo "  Status: {$order['status']}\n";
            echo "  Date: {$order['created_at']}\n\n";
        }
        
        // Check specifically for approved wholesaler orders
        $approvedWholesalerOrders = array_filter($orders, function($order) {
            return $order['status'] === 'approved' && $order['seller_role'] === 'wholesaler';
        });
        
        echo "Approved wholesaler orders: " . count($approvedWholesalerOrders) . "\n";
        if (empty($approvedWholesalerOrders)) {
            echo "No approved wholesaler orders! This is why purchased quantities are 0.\n";
        } else {
            echo "These should show in inventory:\n";
            foreach ($approvedWholesalerOrders as $order) {
                echo "- {$order['quantity']} x {$order['product_name']}\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
