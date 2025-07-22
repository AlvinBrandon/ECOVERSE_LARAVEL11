<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

try {
    $ml = new App\Services\MachineLearningService();
    echo "Testing ML Service Training...\n";
    
    $result = $ml->trainModel();
    
    if ($result && isset($result['status'])) {
        echo "Status: " . $result['status'] . "\n";
        echo "Message: " . ($result['message'] ?? 'No message') . "\n";
        
        if (isset($result['statistics'])) {
            echo "Samples processed: " . $result['samples_processed'] . "\n";
            echo "Accuracy: " . ($result['accuracy'] ?? 'N/A') . "\n";
            echo "Features used: " . implode(', ', $result['features_used']) . "\n";
        }
    } else {
        echo "Training result: " . json_encode($result) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
