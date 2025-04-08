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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable(); // Store image path
            $table->unsignedBigInteger('parent_id')->nullable(); // For parent category
            $table->text('description')->nullable();
            $table->enum('status', ['Scheduled', 'Publish', 'Inactive'])->default('Inactive');
            

            // Foreign key constraint (optional, depending on if you want cascading delete/update)
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
