<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);

            $table->string('sku')->unique()->nullable();
            $table->integer('qty')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_stock'])->default('in_stock');

            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('special_price', 10, 2)->nullable();
            $table->timestamp('special_price_from')->nullable();
            $table->timestamp('special_price_to')->nullable();

            $table->string('url_key')->unique()->nullable();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('meta_tag')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('image')->nullable();            // Main Image
            $table->string('thumbnail')->nullable();        // Thumbnail Image

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
