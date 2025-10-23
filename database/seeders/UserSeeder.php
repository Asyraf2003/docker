<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'asyrafmubarak738@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), 
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Other',
            'email' => 'other@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), 
            'remember_token' => Str::random(10),
            'role' => 'other',
        ]);
        
        User::factory()
        ->count(4)
        ->create([
            'password' => Hash::make('12345678'),
            'role' => 'other',
        ]);
        
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), 
            'remember_token' => Str::random(10),
            'role' => 'user',
        ]);

        User::factory()
            ->count(14)
            ->create([
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);
    }
}