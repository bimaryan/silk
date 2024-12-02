<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_barang' => $this->faker->words(3, true), // Nama barang acak
            'foto' => $this->faker->imageUrl(640, 480, 'products', true), // URL gambar
            'deskripsi' => $this->faker->sentence(10), // Deskripsi acak
            'kategori_id' => $this->faker->numberBetween(1, 2), // ID kategori acak (sesuaikan range)
            'satuan_id' => $this->faker->numberBetween(1, 9), // ID satuan acak (sesuaikan range)
        ];
    }
}
