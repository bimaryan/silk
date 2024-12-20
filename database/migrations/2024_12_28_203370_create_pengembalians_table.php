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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');
            $table->unsignedBigInteger('peminjaman_id');
            $table->enum('persetujuan', ['Belum Dikembalikan', 'Menunggu Verifikasi', 'Dikembalikan'])->default('Belum Dikembalikan');
            $table->string('tindakan_spo_pengguna')->nullable(); //untuk pengguna mengisi informasi dari peminjaman alat/bahan ini [contohnya tindakan yang sudah di lakukan oleh peminjam]

            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('cascade');
            $table->timestamps();
            $table->index(['user_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
