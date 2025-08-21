<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
        $table->id();
        $table->string('title', 255);
        $table->string('heading', 255);
        $table->integer('ordering');
        $table->integer('status'); 
         $table->string('url_key', 255); 
        $table->string('image', 255)->nullable();
        $table->text('description')->nullable(); 
        $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
