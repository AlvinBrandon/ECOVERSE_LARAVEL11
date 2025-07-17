<?php
/**
 * PHP Memory Limit Checker and Fixer for EcoVerse
 * 
 * This script checks and optionally increases PHP memory limits for 
 * better performance with Laravel Reverb WebSockets.
 */

// Current memory limit
$currentLimit = ini_get('memory_limit');
$bytesCurrentLimit = return_bytes($currentLimit);

// Desired memory limit (1GB)
$desiredLimit = '1024M';
$bytesDesiredLimit = return_bytes($desiredLimit);

echo "EcoVerse PHP Memory Configuration\n";
echo "--------------------------------\n";
echo "Current PHP memory limit: $currentLimit (" . format_bytes($bytesCurrentLimit) . ")\n";

// Check if current limit is less than desired
if ($bytesCurrentLimit < $bytesDesiredLimit) {
    echo "Memory limit is too low for optimal WebSocket performance.\n";
    
    // Try to increase memory limit
    if (ini_set('memory_limit', $desiredLimit)) {
        $newLimit = ini_get('memory_limit');
        echo "Successfully increased memory limit to: $newLimit\n";
    } else {
        echo "WARNING: Failed to increase memory limit. You may experience issues with WebSockets.\n";
        echo "To fix this, add the following to your php.ini file:\n";
        echo "memory_limit = 1024M\n";
    }
} else {
    echo "Memory limit is sufficient for WebSocket operation.\n";
}

echo "\nRecommended Settings for php.ini:\n";
echo "memory_limit = 1024M\n";
echo "max_execution_time = 0 ; For WebSocket server\n";
echo "max_input_time = 60\n";
echo "post_max_size = 100M\n";
echo "upload_max_filesize = 100M\n";

// Function to convert memory limit string (like 128M) to bytes
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    
    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    
    return $val;
}

// Function to format bytes to human-readable format
function format_bytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}
