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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->string('nama_dosen')->nullable();
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->unsignedBigInteger('matkul_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->unsignedBigInteger('dokumenspo_id')->nullable();
            $table->string('stock_pinjam')->nullable();
            $table->string('barang_rusak_atau_hilang')->nullable();
            $table->dateTime('tanggal_waktu_peminjaman')->nullable();
            $table->time('waktu_pengembalian')->nullable();
            $table->string('anggota_kelompok')->nullable();
            $table->enum('aprovals', ['Ya', 'Tidak', 'Belum'])->default('Belum');
            $table->enum('aprovals_pengembalian', ['Ya', 'Tidak', 'Belum'])->default('Belum');
            $table->enum('status', ['Dipinjamkan', 'Dikembalikan', 'Menunggu Persetujuan'])->default('Menunggu Persetujuan');
            $table->enum('status_pengembalian', ['Belum', 'Diserahkan'])->default('Belum');
            $table->enum('kondisi', ['Baik', 'Rusak', 'Hilang'])->nullable();
            $table->string('tindakan_spo')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('catatan')->nullable();
            $table->enum('jenis_peminjaman', ['Ruangan', 'Barang']);
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas');
            $table->foreign('matkul_id')->references('id')->on('mata_kuliahs');
            $table->foreign('dosen_id')->references('id')->on('dosens');
            $table->foreign('ruangan_id')->references('id')->on('ruangans');
            $table->foreign('dokumenspo_id')->references('id')->on('dokumen_spos');
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
