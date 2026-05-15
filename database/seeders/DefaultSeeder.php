<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::create([
            'username' => 'admin',
            'password_hash' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'full_name' => 'System Administrator',
            'role' => 'Administrator',
            'is_active' => true,
        ]);

        // Default Settings
        $settings = [
            'barangay_name' => 'Sampaguita',
            'municipality' => 'Cabanatuan City',
            'province' => 'Nueva Ecija',
            'region' => 'Region III',
            'punong_barangay' => 'Juan Dela Cruz',
            'punong_title' => 'Punong Barangay',
            'or_prefix' => 'OR-',
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::create([
                'setting_key' => $key,
                'setting_value' => $value,
            ]);
        }
    }
}
