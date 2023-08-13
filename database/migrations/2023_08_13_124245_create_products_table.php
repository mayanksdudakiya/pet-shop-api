<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('category_uuid')->constrained('categories', 'uuid')->cascadeOnDelete();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->float('price');
            $table->text('description');
            $table->json('metadata');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
