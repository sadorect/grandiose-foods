<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('sku')->unique();
            $table->decimal('base_price', 10, 2);
            $table->enum('measurement_type', ['weight', 'volume']);
            $table->json('variants')->comment('Array of size options with prices');
            $table->json('specifications')->nullable();
            $table->integer('min_order_quantity')->default(1);
            $table->integer('stock_quantity');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
