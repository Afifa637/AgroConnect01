<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRegistersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin_registers')->insert([
            'username' => 'Afifa',
            'email' => 'admin@gmail.com',
            'mobile' => '01234567890',
            'dob' => '1990-01-01',
            'division' => 'Dhaka',
            'address' => 'Some address',
            'gender' => 'Female',
            'password' => bcrypt('Abc123'),
            'profile_pic' => 'default.png',
            'condition' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
