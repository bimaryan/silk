<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(SatuanSeeder::class);
        $this->call(RuanganSeeder::class);
        // $this->call(BarangSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(MahasiswaSeeder::class);
        $this->call(MataKuliah::class);
        $this->call(DosenSeeder::class);
    }
}
