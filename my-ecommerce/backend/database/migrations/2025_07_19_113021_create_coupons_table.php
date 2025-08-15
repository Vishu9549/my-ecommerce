<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('coupon_code')->unique();
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->decimal('discount_amount', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
