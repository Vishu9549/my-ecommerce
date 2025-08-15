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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
        $table->integer('order_increment_id')->nullable();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('name')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('address_2')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->string('pincode')->nullable();
        $table->decimal('subtotal', 10, 2)->nullable();
        $table->string('coupon')->nullable();
        $table->decimal('coupon_discount', 10, 2)->nullable();
        $table->decimal('shipping_cost', 10, 2)->nullable();
        $table->decimal('total', 10, 2)->nullable();
        $table->string('payment_method')->nullable();
        $table->string('shipping_method')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
