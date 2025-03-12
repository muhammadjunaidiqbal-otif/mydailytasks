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
        Schema::table('cities', function (Blueprint $table) {
            // First drop the existing foreign key and column
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            // Add new state_id column and foreign key
            $table->unsignedBigInteger('state_id')->after('name');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('cities', function (Blueprint $table) {
            // Rollback state_id and foreign key
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');

            // Add country_id back
            $table->unsignedBigInteger('country_id')->after('name');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }
};
