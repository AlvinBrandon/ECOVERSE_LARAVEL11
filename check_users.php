<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Current users in the system:\n";
echo "ID | Name | Email | Role | Role_As\n";
echo "---|------|-------|------|--------\n";

$users = User::all(['id', 'name', 'email', 'role', 'role_as']);
foreach($users as $user) {
    $roleName = match($user->role_as) {
        0 => 'customer',
        1 => 'admin', 
        2 => 'retailer',
        3 => 'staff',
        4 => 'supplier',
        5 => 'wholesaler',
        default => 'unknown'
    };
    echo "{$user->id} | {$user->name} | {$user->email} | {$user->role} | {$user->role_as} ({$roleName})\n";
}
