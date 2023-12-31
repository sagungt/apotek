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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->string('no_faktur')->unique()->nullable();
            $table->date('tanggal')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->string('tipe');
            $table->string('nama_dokter')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('no_resep')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
