<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['super admin', 'staff'] as $role) {
            User::create([
                'name' => Str::title($role),
                'email' => Str::remove(' ', $role) . '@tokoku.com',
                'email_verified_at' => now(),
                'password' => Hash::make(env('DEFAULT_USER_PASSWORD')),
                'role' => $role,
                'remember_token' => Str::random(10)
            ]);
        }
    }
}
