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
        Schema::create('pages', function (Blueprint $table) {
        $table->id();
        $table->string('title', 255);
        $table->string('heading', 255);
        $table->integer('ordering'); // int(11)
        $table->integer('status'); // int(11)
         $table->string('url_key', 255); // VARCHAR NULL
        $table->string('image', 255)->nullable();
        $table->text('description')->nullable(); // TEXT NULL
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
