<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Java Server Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to your Java document verification server
    |
    */

    'url' => env('JAVA_SERVER_URL', 'http://localhost:8080'),
    
    'api_key' => env('JAVA_SERVER_API_KEY'),
    
    'timeout' => env('JAVA_SERVER_TIMEOUT', 60),
    
    'max_file_size' => env('JAVA_SERVER_MAX_FILE_SIZE', 10240), // KB
    
    'supported_formats' => ['pdf', 'jpg', 'jpeg', 'png', 'tiff'],
    
    'endpoints' => [
        'verify_documents' => '/api/verify-vendor-documents',
        'verify_ursb' => '/api/verify-ursb',
        'check_authenticity' => '/api/check-authenticity',
        'extract_data' => '/api/extract-data',
        'verification_status' => '/api/verification-status',
    ],
    
    'retry_attempts' => 3,
    
    'retry_delay' => 1000, // milliseconds
];
