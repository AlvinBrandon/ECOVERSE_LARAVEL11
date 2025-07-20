<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Create a new wholesaler user
$user = User::create([
    'name' => 'Wholesaler Demo',
    'email' => 'wholesaler@demo.com',
    'password' => 'password123', // This will be hashed automatically
    'role' => 'wholesaler',
    'role_as' => 5,
    'email_verified_at' => now(),
]);

echo "Created new wholesaler user:\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Password: password123\n";
echo "Role: {$user->role}\n";
echo "Role_as: {$user->role_as}\n";
echo "\nYou can now log in with these credentials!\n";
