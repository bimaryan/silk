<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = ['Admin', 'Staff'];

        foreach ($role as $role) {
            Role::create([
                'nama_role' => $role,
            ]);
        }
    }
}
