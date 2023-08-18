<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('order_status');
            $table->foreignUuid('payment_uuid')->constrained('payments', 'uuid');
            $table->uuid()->unique();
            $table->json('products');
            $table->json('address');
            $table->float('delivery_fee')->nullable();
            $table->float('amount');
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
