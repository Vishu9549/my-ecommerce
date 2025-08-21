<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('quotes_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name')->nullable();
            $table->string('sku')->nullable()->comment('Stock keeping unit');
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('qty')->nullable()->comment('quantity');
            $table->decimal('row_total', 10, 2)->nullable();
            $table->string('custom_option')->nullable();
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes_items');
    }
};
