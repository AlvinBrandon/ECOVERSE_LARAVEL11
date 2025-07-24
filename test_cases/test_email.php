<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test email sending with vendor-like content
    $emailContent = "Dear Test Vendor,\n\n";
    $emailContent .= "🎉 This is a test email from Ecoverse! 🎉\n\n";
    $emailContent .= "Your email configuration is working correctly.\n\n";
    $emailContent .= "Best regards,\n";
    $emailContent .= "The Ecoverse Team";
    
    Mail::raw($emailContent, function ($message) {
        $message->to('ecoverseltd0@gmail.com') // Send test to your own email
                ->subject('✅ Test Email from Ecoverse - Email Service Working!');
    });
    
    echo "✅ Email sent successfully!\n";
    echo "Check your Gmail inbox (ecoverseltd0@gmail.com) for the test email.\n";
    echo "📧 Your vendor validation emails will now be sent automatically!\n";
} catch (Exception $e) {
    echo "❌ Email failed to send: " . $e->getMessage() . "\n";
    echo "Please check your Gmail configuration.\n";
}
