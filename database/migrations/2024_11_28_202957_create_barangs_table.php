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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('satuan_id');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->foreign('satuan_id')->references('id')->on('satuans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
