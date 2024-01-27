<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role_admin = Role::create([
            'name' => 'admin'
        ]);

        $role_kordinator = Role::create([
            'name' => 'kordinator'
        ]);

        $role_pembimbing = Role::create([
            'name' => 'pembimbing'
        ]);

        $role_mahasiswa = Role::create([
            'name' => 'mahasiswa'
        ]);
    }
}
