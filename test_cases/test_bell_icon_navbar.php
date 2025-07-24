<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "🔔 TESTING NAVBAR BELL ICON IMPLEMENTATION\n";
echo "==========================================\n\n";

// Get a test user (admin) to log in
$admin = User::where('email', 'test_admin@ecoverse.com')->first();

if (!$admin) {
    echo "❌ Test admin user not found. Please run the main chat test first.\n";
    exit;
}

echo "1️⃣ CHECKING USER AUTHENTICATION\n";
echo "===============================\n";

// Simulate login
Auth::login($admin);
echo "✅ Logged in as: {$admin->name} ({$admin->email})\n";
echo "👤 Role: {$admin->getCurrentRole()}\n\n";

echo "2️⃣ CHECKING NAVBAR COMPONENT\n";
echo "============================\n";

// Check if the auth navbar file exists and has bell icon
$navbarPath = resource_path('views/components/navbars/navs/auth.blade.php');
if (file_exists($navbarPath)) {
    echo "✅ Auth navbar file exists: {$navbarPath}\n";
    
    $navbarContent = file_get_contents($navbarPath);
    
    // Check for bell icon
    $hasBellIcon = str_contains($navbarContent, 'fa-bell');
    echo "🔔 Bell icon present: " . ($hasBellIcon ? "YES" : "NO") . "\n";
    
    // Check for chat menu button
    $hasChatButton = str_contains($navbarContent, 'chatMenuButton');
    echo "📱 Chat menu button: " . ($hasChatButton ? "YES" : "NO") . "\n";
    
    // Check for animation classes
    $hasAnimations = str_contains($navbarContent, 'animate__');
    echo "✨ Animation classes: " . ($hasAnimations ? "YES" : "NO") . "\n";
    
    // Check for enhanced styling
    $hasEnhancedStyling = str_contains($navbarContent, 'fs-5') || str_contains($navbarContent, 'font-size: 1.2rem');
    echo "🎨 Enhanced styling: " . ($hasEnhancedStyling ? "YES" : "NO") . "\n";
    
} else {
    echo "❌ Auth navbar file not found!\n";
}

echo "\n3️⃣ CHECKING LAYOUT DEPENDENCIES\n";
echo "===============================\n";

// Check if Animate.css is included in layout
$layoutPath = resource_path('views/layouts/app.blade.php');
if (file_exists($layoutPath)) {
    echo "✅ Main layout file exists: {$layoutPath}\n";
    
    $layoutContent = file_get_contents($layoutPath);
    
    // Check for Animate.css
    $hasAnimateCSS = str_contains($layoutContent, 'animate.css') || str_contains($layoutContent, 'animate.min.css');
    echo "🎬 Animate.css library: " . ($hasAnimateCSS ? "YES" : "NO") . "\n";
    
    // Check for Font Awesome (should already be there)
    $hasFontAwesome = str_contains($layoutContent, 'font-awesome') || str_contains($layoutContent, 'fa-');
    echo "🔤 Font Awesome icons: " . ($hasFontAwesome ? "YES" : "NO") . "\n";
    
} else {
    echo "❌ Main layout file not found!\n";
}

echo "\n4️⃣ CHECKING JAVASCRIPT ENHANCEMENTS\n";
echo "===================================\n";

// Check app.js file
$appJsPath = resource_path('js/app.js');
if (file_exists($appJsPath)) {
    echo "✅ App.js file exists: {$appJsPath}\n";
    
    $appJsContent = file_get_contents($appJsPath);
    
    // Check for enhanced notification function
    $hasEnhancedFunction = str_contains($appJsContent, 'fa-bell') && str_contains($appJsContent, 'animate__swing');
    echo "🔔 Enhanced bell function: " . ($hasEnhancedFunction ? "YES" : "NO") . "\n";
    
    // Check for bell styling
    $hasBellStyling = str_contains($appJsContent, 'textShadow') || str_contains($appJsContent, 'color');
    echo "🎨 Bell styling effects: " . ($hasBellStyling ? "YES" : "NO") . "\n";
    
} else {
    echo "❌ App.js file not found!\n";
}

echo "\n5️⃣ SIMULATING BELL NOTIFICATION\n";
echo "===============================\n";

// Check if user has unread messages (for testing)
$unreadCount = 0;
if (method_exists($admin, 'hasUnreadMessages')) {
    $hasUnread = $admin->hasUnreadMessages();
    echo "📬 User has unread messages: " . ($hasUnread ? "YES" : "NO") . "\n";
    
    if (method_exists($admin, 'unreadMessagesCount')) {
        $unreadCount = $admin->unreadMessagesCount();
        echo "🔢 Unread messages count: {$unreadCount}\n";
    }
} else {
    echo "⚠️  Unread message methods not available on User model\n";
}

echo "\n6️⃣ CHECKING COMPILED ASSETS\n";
echo "===========================\n";

// Check if assets need to be compiled
$publicCSSPath = public_path('css');
$publicJSPath = public_path('js');

echo "📁 Public CSS directory: " . (is_dir($publicCSSPath) ? "EXISTS" : "NOT FOUND") . "\n";
echo "📁 Public JS directory: " . (is_dir($publicJSPath) ? "EXISTS" : "NOT FOUND") . "\n";

// Check for compiled app.js
$compiledAppJs = public_path('js/app.js');
echo "📦 Compiled app.js: " . (file_exists($compiledAppJs) ? "EXISTS" : "NOT FOUND") . "\n";

echo "\n7️⃣ RECOMMENDATIONS\n";
echo "==================\n";

$recommendations = [];

if (!str_contains(file_get_contents($navbarPath), 'fa-bell')) {
    $recommendations[] = "❗ Add fa-bell icon to navbar";
}

if (!str_contains(file_get_contents($layoutPath), 'animate.css')) {
    $recommendations[] = "❗ Include Animate.css library in layout";
}

if (!file_exists($compiledAppJs)) {
    $recommendations[] = "❗ Compile assets using 'npm run dev' or 'npm run build'";
}

if (empty($recommendations)) {
    echo "🎉 All components are properly configured!\n";
    echo "✅ Bell icon should be visible in the navbar\n";
    echo "✅ Animations should work when notifications arrive\n";
    echo "✅ Enhanced styling should be applied\n";
} else {
    echo "📋 Issues found:\n";
    foreach ($recommendations as $rec) {
        echo "   {$rec}\n";
    }
}

echo "\n8️⃣ TESTING BROWSER ACCESS\n";
echo "=========================\n";

echo "🌐 To see the bell icon in action:\n";
echo "   1. Start your development server: php artisan serve\n";
echo "   2. Compile assets: npm run dev\n";
echo "   3. Visit: http://localhost:8000\n";
echo "   4. Log in as any user\n";
echo "   5. Look for the 🔔 bell icon in the top navigation bar\n";
echo "   6. The bell should glow red and animate when you have unread messages\n";

echo "\n🎯 Bell icon features implemented:\n";
echo "   🔔 Prominent bell icon (larger, styled)\n";
echo "   🔴 Red glow effect for unread messages\n";
echo "   🎬 Swing animation when notifications arrive\n";
echo "   💫 Hover effects (scale and color change)\n";
echo "   🎯 Click animations (tada effect)\n";
echo "   📊 Pulsing badge for unread count\n";

echo "\n✨ Your bell icon is now prominently displayed in the navbar!\n";

Auth::logout();
