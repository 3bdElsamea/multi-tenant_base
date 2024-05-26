<?php

namespace Database\Seeders\CentralApp;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Create User Of Type super_admin
        User::create([
            'full_name' => "Super Admin",
            'phone_code' => "+20",
            'phone' => "12345678",
            'email' => "super-admin@info.com",
            'email_verified_at' => now()->addDay(rand(1, 6)),
            'password' => '123456789', // secret
            'is_active' => 1,
            'user_type' => 'super_admin', // secret
            'remember_token' => Str::random(10),
        ]);
    }
}
