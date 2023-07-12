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
        Schema::create('obat', function (Blueprint $table) {
            $table->id('obat_id');
            $table->string('nama_obat');
            $table->string('satuan');
            $table->bigInteger('harga')->default(0);
            $table->foreignId('kategori_id')
                ->references('kategori_id')
                ->on('kategori');
            // $table->foreignId('merek_id')
            //     ->references('merek_id')
            //     ->on('merek');
            $table->string('jenis');
            $table->string('minimal_stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
