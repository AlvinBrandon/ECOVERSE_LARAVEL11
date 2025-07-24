<?php
/**
 * Test script to simulate Java server responses for vendor validation
 */

require_once __DIR__ . '/vendor/autoload.php';

// Define test response scenarios
$responses = [
    'success' => [
        'status' => 'success',
        'message' => 'Documents verified successfully! Your application has been approved.',
        'additional_info' => 'A confirmation email with site visit details has been sent to your email address.',
        'verification_score' => 95,
        'document_statuses' => [
            'registration_certificate' => 'verified',
            'ursb_document' => 'verified', 
            'trading_license' => 'verified'
        ],
        'recommendations' => [
            'Site visit scheduled within 48 hours',
            'Vendor status will be activated upon successful site verification'
        ]
    ],
    
    'failed' => [
        'status' => 'failed',
        'message' => 'Invalid documents have been detected. Please check your documents and reapply.',
        'additional_info' => 'A detailed rejection email has been sent to your email address.',
        'verification_score' => 25,
        'document_statuses' => [
            'registration_certificate' => 'invalid',
            'ursb_document' => 'forged',
            'trading_license' => 'expired'
        ],
        'error_details' => [
            'URSB document appears to be forged',
            'Trading license has expired',
            'Registration certificate contains invalid signatures'
        ]
    ],
    
    'pending' => [
        'status' => 'pending',
        'message' => 'Document verification service is currently unavailable. Your application is pending manual review.',
        'additional_info' => 'A confirmation email has been sent to your email address.',
        'verification_score' => null,
        'reason' => 'Java server temporarily unavailable'
    ],
    
    'error' => [
        'status' => 'error',
        'message' => 'Failed to submit application. Please try again.',
        'additional_info' => 'Connection to verification service failed',
        'error_code' => 'CONNECTION_ERROR'
    ]
];

echo "Vendor Java Server Response Test Scenarios:\n";
echo "==========================================\n\n";

foreach ($responses as $scenario => $response) {
    echo "Scenario: " . strtoupper($scenario) . "\n";
    echo "JSON Response:\n";
    echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
    echo str_repeat("-", 60) . "\n\n";
}

echo "✅ Test responses generated successfully!\n";
echo "These responses will be displayed in the vendor application form\n";
echo "when the Java server returns verification results.\n";
?>
