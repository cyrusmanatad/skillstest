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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('sku_code')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('price_adjustment', 10, 2)->default(0); // Default to 0 if not provided
            $table->string('image')->nullable();
            $table->tinyInteger('del_flag')->default(1); // 1: active, 0: deleted
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
