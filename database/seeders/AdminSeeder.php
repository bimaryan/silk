<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admins = [
            [
                'nama' => 'Admin 1',
                'nip' => '1231234123123',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ],
            [
                'nama' => 'Staff 1',
                'nip' => '09871239812',
                'username' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
