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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pengguna
            $table->string('user_type'); // Polymorphic relationship
            $table->unsignedBigInteger('matkul_id')->nullable();
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->string('nama_dosen')->nullable();
            $table->dateTime('tanggal_waktu_peminjaman');
            $table->time('waktu_pengembalian')->nullable();
            $table->enum('persetujuan', ['Belum Diserahkan', 'Diserahkan', 'Selesai'])->default('Belum Diserahkan');
            $table->unsignedBigInteger('dokumenspo_id')->nullable();
            $table->string('anggota_kelompok')->nullable();
            $table->enum('jenis_peminjaman', ['Ruangan', 'Barang']);
            $table->timestamps();

            $table->index(['user_id', 'user_type']);
            $table->foreign('matkul_id')->references('id')->on('mata_kuliahs')->onDelete('cascade');
            $table->foreign('dokumenspo_id')->references('id')->on('dokumen_spos')->onDelete('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
