<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create CS account
        User::create([
            'name' => 'Customer Service',
            'email' => 'cs@example.com',
            'password' => Hash::make('Dki12345!'),
            'role' => 'CS',
        ]);

        // Create Supervisi account
        User::create([
            'name' => 'Supervisi',
            'email' => 'supervisi@example.com',
            'password' => Hash::make('Dki12345!'),
            'role' => 'Supervisi',
        ]);
    }
}
