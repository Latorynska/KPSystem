<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@kpsystem.com',
            'email_verified_at' => now(),
            'nomor_induk' => 'Admin',
            'password' => Hash::make('Password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin->assignRole('admin');

        $kordinator = User::create([
            'name' => 'Kordinator',
            'email' => 'kordinator@kpsystem.com',
            'email_verified_at' => now(),
            'nomor_induk' => 'Kordinator',
            'password' => Hash::make('Password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $kordinator->assignRole('kordinator');
    }
}
