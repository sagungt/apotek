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
            $table->string('name');
            $table->string('uom');
            $table->integer('qty')->default(0);
            $table->bigInteger('purchase_price')->default(0);
            $table->bigInteger('selling_price')->default(0);
            $table->text('description')->nullable();
            $table->date('expiry_date');
            $table->string('type');
            $table->foreignId('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
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
