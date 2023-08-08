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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('pembelian_id');
            $table->string('no_faktur')->unique()->nullable();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->bigInteger('total')->nullable();
            $table->string('status')->nullable();
            $table->text('keterangan')->nullable();
            // $table->foreignId('supplier_id')
            //     ->references('supplier_id')
            //     ->on('supplier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
