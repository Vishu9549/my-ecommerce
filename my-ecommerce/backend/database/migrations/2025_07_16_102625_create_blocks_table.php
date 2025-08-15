// database/migrations/2025_07_24_000001_create_blocks_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('heading', 255);
            $table->integer('ordering')->default(0);
            $table->string('identifier', 255)->nullable(); // for custom use like "wehelp", "whychooseus"
            $table->integer('status')->default(1); // 1 = active, 0 = inactive
            $table->string('image', 255)->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable(); // optional main image
            $table->json('features');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
