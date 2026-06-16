<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // [PERUBAHAN] Membuat akun admin default untuk mengelola sistem WarungKu
        User::updateOrCreate(
            [
                'email' => 'adminwarungku@gmail.com',
            ],
            [
                'name' => 'Admin WarungKu',
                'password' => Hash::make('AdminWarungKu'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}