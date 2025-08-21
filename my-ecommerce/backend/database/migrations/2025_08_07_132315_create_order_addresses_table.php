<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_addresses', function (Blueprint $table) {
           $table->id();
           $table->integer('order_id')->nullable();
           $table->integer('user_id')->nullable();
           $table->string('name')->nullable();
           $table->string('email')->nullable();
           $table->string('phone')->nullable();
           $table->string('address')->nullable();
           $table->string('address_2')->nullable();
           $table->string('city')->nullable();
           $table->string('state')->nullable();
           $table->string('country')->nullable();
           $table->string('pincode')->nullable();
           $table->string('address_type')->nullable();
           $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
