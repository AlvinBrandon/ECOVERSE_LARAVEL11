<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Low Stock Alert</title>
</head>
<body>
    <h2>Low Stock Alert</h2>
    <p>The following product is low on stock:</p>
    <ul>
        <li><strong>Product:</strong> {{ $productName }}</li>
        <li><strong>Batch ID:</strong> {{ $batchId }}</li>
        <li><strong>Quantity:</strong> {{ $quantity }}</li>
    </ul>
    <p>Please restock as soon as possible.</p>
</body>
</html>
