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
        Schema::create('persediaan_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')
                ->references('obat_id')
                ->on('obat');
            $table->integer('stok');
            $table->bigInteger('harga_jual');
            $table->string('no_batch');
            $table->date('no_exp');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persediaan_obat');
    }
};
