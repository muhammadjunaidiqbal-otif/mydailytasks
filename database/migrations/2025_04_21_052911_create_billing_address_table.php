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
        Schema::create('billing_address', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('country_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('state_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('city_id')->constrained()->onDelete('cascade');
            $table->string('postal_code');
            $table->string('phone');
            $table->string('email');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_address');
    }
};
