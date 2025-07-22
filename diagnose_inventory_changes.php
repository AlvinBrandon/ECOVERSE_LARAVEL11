<?php

// Diagnose recent inventory changes
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=eco', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== INVENTORY CHANGE DIAGNOSIS ===\n\n";
    
    // Get stock changes for today
    $stmt = $pdo->prepare("
        SELECT sh.*, p.name as product_name, u.name as user_name
        FROM stock_histories sh
        JOIN inventories i ON sh.inventory_id = i.id
        JOIN products p ON i.product_id = p.id
        JOIN users u ON sh.user_id = u.id
        WHERE DATE(sh.created_at) = CURDATE()
        ORDER BY sh.created_at DESC
    ");
    $stmt->execute();
    $changes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $productSummary = [];
    
    echo "DETAILED CHANGE LOG:\n";
    echo str_repeat("=", 80) . "\n";
    
    foreach ($changes as $change) {
        $changeAmount = $change['quantity_after'] - $change['quantity_before'];
        $sign = $changeAmount > 0 ? '+' : '';
        
        echo "[{$change['created_at']}] {$change['product_name']}\n";
        echo "  User: {$change['user_name']}\n";
        echo "  Action: " . strtoupper($change['action']) . "\n";
        echo "  Change: {$change['quantity_before']} → {$change['quantity_after']} ({$sign}{$changeAmount})\n";
        echo "  Note: {$change['note']}\n";
        echo str_repeat("-", 40) . "\n";
        
        // Track product summary
        if (!isset($productSummary[$change['product_name']])) {
            $productSummary[$change['product_name']] = [
                'added' => 0,
                'deducted' => 0,
                'net' => 0
            ];
        }
        
        if ($changeAmount > 0) {
            $productSummary[$change['product_name']]['added'] += $changeAmount;
        } else {
            $productSummary[$change['product_name']]['deducted'] += abs($changeAmount);
        }
        $productSummary[$change['product_name']]['net'] += $changeAmount;
    }
    
    echo "\n\nPRODUCT SUMMARY FOR TODAY:\n";
    echo str_repeat("=", 80) . "\n";
    
    foreach ($productSummary as $product => $summary) {
        echo "{$product}:\n";
        echo "  Added: +{$summary['added']} units\n";
        echo "  Deducted: -{$summary['deducted']} units\n";
        echo "  Net Change: " . ($summary['net'] >= 0 ? '+' : '') . "{$summary['net']} units\n";
        echo str_repeat("-", 40) . "\n";
    }
    
    // Check current vs historical
    echo "\n\nCURRENT STATUS vs EXPECTED:\n";
    echo str_repeat("=", 80) . "\n";
    
    $stmt = $pdo->prepare("
        SELECT p.name, SUM(i.quantity) as current_total
        FROM products p
        LEFT JOIN inventories i ON p.id = i.product_id
        GROUP BY p.id, p.name
        HAVING current_total > 0
        ORDER BY p.name
    ");
    $stmt->execute();
    $currentLevels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($currentLevels as $level) {
        echo "{$level['name']}: {$level['current_total']} units currently\n";
        
        if (isset($productSummary[$level['name']])) {
            $netChange = $productSummary[$level['name']]['net'];
            if ($netChange < -500) {
                echo "  ⚠️  SIGNIFICANT REDUCTION: {$netChange} units today\n";
            } elseif ($netChange > 500) {
                echo "  ✅ SIGNIFICANT INCREASE: +{$netChange} units today\n";
            }
        }
    }
    
    echo "\n\n=== ANALYSIS ===\n";
    echo "If you see significant reductions, they are likely due to:\n";
    echo "1. Admin approving wholesaler purchase orders (normal business flow)\n";
    echo "2. Wholesalers approving retailer orders (inventory moves down chain)\n";
    echo "3. Retailers processing customer orders (final sale)\n";
    echo "4. Bulk verification operations processing multiple orders at once\n\n";
    
    echo "This is normal supply chain operation unless:\n";
    echo "- You see unexplained large deductions without corresponding orders\n";
    echo "- Inventory goes below what you recently added\n";
    echo "- Changes don't match your business activities\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
