<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained();
        $table->string('product_name');
        $table->decimal('unit_price', 10, 2);
        $table->integer('quantity');
        $table->string('size');
        $table->string('measurement_unit');
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
    });
  }
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
}



