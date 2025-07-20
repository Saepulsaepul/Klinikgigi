<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang lebih kuat
            'role' => 'admin',
        ]);

        $this->command->info('Admin user created successfully!');
    }
}