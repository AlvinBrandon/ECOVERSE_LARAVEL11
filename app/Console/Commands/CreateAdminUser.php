<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {email?} {password?}';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@ecoverse.com';
        $password = $this->argument('password') ?? 'admin123';

        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            $existingUser->update([
                'role' => 'admin',
                'password' => Hash::make($password)
            ]);
            $this->info("Updated existing user as admin: {$email}");
            return;
        }

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);

        $this->info("Created new admin user: {$email}");
    }
}
