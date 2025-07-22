<?php

// Check what happened with Order #62 verification
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Order #62 Verification Analysis ===\n\n";
    
    // Check inventory changes around the time of order #62
    echo "Inventory record #3 history (the one with 607 pcs):\n";
    $stmt = $pdo->prepare("
        SELECT id, quantity, batch_id, created_at, updated_at
        FROM inventories 
        WHERE id = 3
    ");
    $stmt->execute();
    $inv3 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Inventory #3:\n";
    echo "- Current quantity: {$inv3['quantity']} pcs\n";
    echo "- Batch: {$inv3['batch_id']}\n";
    echo "- Created: {$inv3['created_at']}\n";
    echo "- Updated: {$inv3['updated_at']}\n\n";
    
    // Check Order #62 details
    $stmt = $pdo->prepare("
        SELECT o.*, u.name as user_name, p.name as product_name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN products p ON o.product_id = p.id
        WHERE o.id = 62
    ");
    $stmt->execute();
    $order62 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Order #62 details:\n";
    echo "- Quantity: {$order62['quantity']} pcs\n";
    echo "- Product: {$order62['product_name']}\n";
    echo "- User: {$order62['user_name']}\n";
    echo "- Status: {$order62['status']}\n";
    echo "- Created: {$order62['created_at']}\n";
    echo "- Updated: {$order62['updated_at']}\n\n";
    
    // The problem might be that the verification added inventory instead of deducting
    echo "=== Analysis ===\n";
    echo "The issue appears to be:\n";
    echo "1. Order #62 was for 607 pcs of Paperboard cartons\n";
    echo "2. When verified, it should have DEDUCTED 607 from existing inventory\n";
    echo "3. But instead, it looks like inventory #3 now HAS exactly 607 pcs\n";
    echo "4. This suggests the verification logic might have SET the quantity to 607\n";
    echo "   instead of subtracting 607 from the existing amount\n\n";
    
    // Check if there's a stock history record
    echo "Checking for stock history records:\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'stock_histories'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("
            SELECT * FROM stock_histories 
            WHERE inventory_id = 3 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $stmt->execute();
        $histories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($histories)) {
            echo "No stock history found for inventory #3\n";
        } else {
            foreach ($histories as $history) {
                echo "- {$history['action']}: {$history['quantity_before']} → {$history['quantity_after']} ({$history['note']})\n";
            }
        }
    } else {
        echo "Stock histories table doesn't exist\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
