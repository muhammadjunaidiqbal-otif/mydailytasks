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
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->enum('status', ['Scheduled', 'Publish', 'Inactive'])->default('Publish');
            $table->decimal('base_price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->boolean('charge_tax')->default(false);
            $table->boolean('in_stock')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
