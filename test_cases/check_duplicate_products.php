<?php

// Check for duplicate products in the database
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DUPLICATE PRODUCT ANALYSIS ===\n\n";
    
    // Find products with the same name
    $stmt = $pdo->prepare("
        SELECT name, COUNT(*) as count
        FROM products 
        GROUP BY name
        HAVING count > 1
        ORDER BY count DESC, name
    ");
    $stmt->execute();
    $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($duplicates)) {
        echo "✅ No duplicate product names found.\n";
    } else {
        echo "⚠️  Found duplicate product names:\n";
        echo str_repeat("=", 70) . "\n";
        
        foreach ($duplicates as $duplicate) {
            echo "\n📦 Product: {$duplicate['name']} ({$duplicate['count']} entries)\n";
            
            // Get details for each duplicate
            $stmt2 = $pdo->prepare("
                SELECT p.id, p.name, p.seller_role, p.price, p.created_at,
                       COALESCE(SUM(i.quantity), 0) as total_inventory
                FROM products p
                LEFT JOIN inventories i ON p.id = i.product_id
                WHERE p.name = ?
                GROUP BY p.id
                ORDER BY p.id
            ");
            $stmt2->execute([$duplicate['name']]);
            $products = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($products as $product) {
                echo "  • ID: {$product['id']} | Role: {$product['seller_role']} | ";
                echo "Price: {$product['price']} | Inventory: {$product['total_inventory']} units\n";
                echo "    Created: {$product['created_at']}\n";
                
                // Get inventory details
                $stmt3 = $pdo->prepare("
                    SELECT id, quantity, batch_id, created_at
                    FROM inventories 
                    WHERE product_id = ?
                    ORDER BY created_at
                ");
                $stmt3->execute([$product['id']]);
                $inventories = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($inventories)) {
                    foreach ($inventories as $inv) {
                        echo "      - Inventory #{$inv['id']}: {$inv['quantity']} units (batch: {$inv['batch_id']})\n";
                    }
                } else {
                    echo "      - No inventory records\n";
                }
            }
        }
        
        echo "\n" . str_repeat("=", 70) . "\n";
        echo "🔍 ANALYSIS:\n";
        echo "This duplication is likely due to the supply chain system creating\n";
        echo "separate product records for different seller roles:\n";
        echo "• Factory/Admin products (for wholesalers)\n";
        echo "• Retailer products (for customers)\n\n";
        
        echo "💡 RECOMMENDATION:\n";
        echo "If this is unintentional duplication, you may want to:\n";
        echo "1. Consolidate inventory into single product records\n";
        echo "2. Use role-based access control instead of separate products\n";
        echo "3. Clean up duplicate entries\n";
    }
    
    // Check total products and inventory
    echo "\n" . str_repeat("=", 70) . "\n";
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $totalProducts = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM inventories");
    $totalInventories = $stmt->fetchColumn();
    
    echo "📊 SUMMARY:\n";
    echo "Total products: {$totalProducts}\n";
    echo "Total inventory records: {$totalInventories}\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
