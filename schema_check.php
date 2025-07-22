<?php

// Check database schema
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Database Schema Check ===\n\n";
    
    // Check users table structure
    echo "Users table structure:\n";
    $stmt = $pdo->query("PRAGMA table_info(users)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Column: {$row['name']}, Type: {$row['type']}\n";
    }
    
    // Check products table structure
    echo "\nProducts table structure:\n";
    $stmt = $pdo->query("PRAGMA table_info(products)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Column: {$row['name']}, Type: {$row['type']}\n";
    }
    
    // Check orders table structure
    echo "\nOrders table structure:\n";
    $stmt = $pdo->query("PRAGMA table_info(orders)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Column: {$row['name']}, Type: {$row['type']}\n";
    }
    
    // Try to find any users
    echo "\nChecking available columns in users table:\n";
    $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
    $columns = array_keys($stmt->fetch(PDO::FETCH_ASSOC) ?: []);
    echo "Available columns: " . implode(', ', $columns) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
