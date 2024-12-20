<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalian_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengembalian_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah_pinjam')->unsigned();
            $table->integer('jumlah_kembali')->unsigned();
            $table->enum('kondisi', ['Rusak', 'Hilang', 'Habis', 'Dikembalikan'])->default('Dikembalikan');
            $table->text('catatan')->nullable(); // untuk ketika kondisi hilang, rusak
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('pengembalian_id')->references('id')->on('pengembalians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_details');
    }
};
