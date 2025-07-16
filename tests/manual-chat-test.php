<?php
// This is a manual test script for checking the chat polling functionality

// First, make sure to run:
// php artisan serve

$baseUrl = "http://localhost:8000";
$roomId = 5; // Change this to a valid room ID from your database
$csrfToken = null;

echo "=== ECOVERSE CHAT POLLING TEST ===\n\n";

// 1. Get CSRF Token (by parsing the HTML of the homepage)
echo "1. Getting CSRF token...\n";
$homepageContent = file_get_contents($baseUrl);
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $homepageContent, $matches)) {
    $csrfToken = $matches[1];
    echo "   ✓ CSRF token obtained: " . substr($csrfToken, 0, 10) . "...\n";
} else {
    echo "   ✗ Failed to get CSRF token. Make sure you're logged in.\n";
    exit(1);
}

// 2. Test getting messages
echo "\n2. Testing messages endpoint for room $roomId...\n";
$messagesUrl = $baseUrl . "/chat/poll/messages?room_id={$roomId}&last_id=0";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $messagesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-CSRF-TOKEN: {$csrfToken}",
    "Accept: application/json",
]);
curl_setopt($ch, CURLOPT_COOKIE, "laravel_session=" . get_session_cookie($homepageContent));
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($result, true);
    if (isset($data['messages'])) {
        echo "   ✓ Messages endpoint is working. Found " . count($data['messages']) . " messages.\n";
        echo "   ✓ Last message ID: " . $data['last_id'] . "\n";
    } else {
        echo "   ✗ Messages endpoint returned unexpected data format.\n";
    }
} else {
    echo "   ✗ Messages endpoint failed with HTTP code $httpCode\n";
    echo "   Response: " . $result . "\n";
}

// 3. Test sending a message
echo "\n3. Testing send message endpoint...\n";
$sendUrl = $baseUrl . "/chat/poll/send";
$postData = [
    'room_id' => $roomId,
    'message' => 'Test message from PHP script at ' . date('Y-m-d H:i:s')
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sendUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-CSRF-TOKEN: {$csrfToken}",
    "Accept: application/json",
    "Content-Type: application/x-www-form-urlencoded",
]);
curl_setopt($ch, CURLOPT_COOKIE, "laravel_session=" . get_session_cookie($homepageContent));
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($result, true);
    if (isset($data['success']) && $data['success']) {
        echo "   ✓ Message sent successfully! Message ID: " . $data['message']['id'] . "\n";
    } else {
        echo "   ✗ Failed to send message.\n";
        echo "   Response: " . print_r($data, true) . "\n";
    }
} else {
    echo "   ✗ Send message endpoint failed with HTTP code $httpCode\n";
    echo "   Response: " . $result . "\n";
}

// 4. Test online users endpoint
echo "\n4. Testing online users endpoint...\n";
$onlineUsersUrl = $baseUrl . "/chat/poll/online-users";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $onlineUsersUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-CSRF-TOKEN: {$csrfToken}",
    "Accept: application/json",
]);
curl_setopt($ch, CURLOPT_COOKIE, "laravel_session=" . get_session_cookie($homepageContent));
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($result, true);
    if (isset($data['users'])) {
        echo "   ✓ Online users endpoint is working. Found " . count($data['users']) . " online users.\n";
    } else {
        echo "   ✗ Online users endpoint returned unexpected data format.\n";
    }
} else {
    echo "   ✗ Online users endpoint failed with HTTP code $httpCode\n";
}

echo "\n=== TEST COMPLETE ===\n";

// Helper function to get the session cookie from the homepage HTML
function get_session_cookie($html) {
    // This is a simplified approach and might not work in all cases
    // In a real-world scenario, you would use a proper HTTP client that handles cookies
    if (preg_match('/Set-Cookie: laravel_session=([^;]+)/', $html, $matches)) {
        return $matches[1];
    }
    return '';
}
