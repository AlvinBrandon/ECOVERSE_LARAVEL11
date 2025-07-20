<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Update Victoria Sanyu to be a proper wholesaler
$user = User::find(10);
if ($user) {
    $user->role = 'wholesaler';
    $user->role_as = 5; // Wholesaler role_as value
    $user->save();
    
    echo "Updated user: {$user->name} ({$user->email})\n";
    echo "Role: {$user->role}\n";
    echo "Role_as: {$user->role_as}\n";
    echo "Password: (unchanged - you'll need to reset if you don't know it)\n";
} else {
    echo "User not found!\n";
}
