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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('no_batch');
            $table->date('no_exp');
            $table->string('name');
            $table->string('uom');
            $table->bigInteger('price')->default(0);
            $table->foreignId('category_id')
                ->references('id')
                ->on('categories');
            $table->foreignId('brand_id')
                ->references('id')
                ->on('brands');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
