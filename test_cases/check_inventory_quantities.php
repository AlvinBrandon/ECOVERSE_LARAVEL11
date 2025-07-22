<?php

// Check actual inventory quantities in database vs what's shown on page
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Database Inventory Check ===\n\n";
    
    // Get all products with their inventory quantities
    echo "All products and their inventory quantities:\n";
    $stmt = $pdo->prepare("
        SELECT p.id, p.name, p.seller_role,
               i.id as inventory_id, i.quantity, i.batch_id, i.created_at
        FROM products p
        LEFT JOIN inventories i ON p.id = i.product_id
        ORDER BY p.name, i.id
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $productTotals = [];
    
    foreach ($results as $row) {
        $productName = $row['name'];
        
        if (!isset($productTotals[$productName])) {
            $productTotals[$productName] = [
                'total_quantity' => 0,
                'seller_role' => $row['seller_role'],
                'inventories' => []
            ];
        }
        
        if ($row['inventory_id']) {
            $productTotals[$productName]['total_quantity'] += $row['quantity'];
            $productTotals[$productName]['inventories'][] = [
                'id' => $row['inventory_id'],
                'quantity' => $row['quantity'],
                'batch_id' => $row['batch_id']
            ];
        }
    }
    
    echo "Product Summary (totals):\n";
    echo "========================\n";
    foreach ($productTotals as $name => $data) {
        echo "{$name}: {$data['total_quantity']} pcs (seller: {$data['seller_role']})\n";
        
        if (!empty($data['inventories'])) {
            echo "  Inventory breakdown:\n";
            foreach ($data['inventories'] as $inv) {
                echo "    - Inventory #{$inv['id']}: {$inv['quantity']} pcs (batch: {$inv['batch_id']})\n";
            }
        }
        echo "\n";
    }
    
    // Compare with what should be shown on inventory page
    echo "=== Comparing with Inventory Page ===\n";
    echo "From your screenshot, the inventory page shows:\n";
    echo "- Corrugated cardboard: 7490 pcs\n";
    echo "- Kraft paper: 4001 pcs\n";
    echo "- Paperboard cartons: 140 pcs\n";
    echo "- Newspaper wrap: 150 pcs\n";
    echo "- Molded pulp trays: 189 pcs\n";
    echo "- PET (Polyethylene Terephthalate): 190 pcs\n";
    echo "- HDPE (High-Density Polyethylene): 305 pcs\n\n";
    
    echo "Let's see if these match the database totals above.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
