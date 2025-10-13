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
        Schema::table('flights', function (Blueprint $table) {
            $table->foreignId('airline_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('from_city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('to_city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('available_seats')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropForeign(['airline_id']);
            $table->dropForeign(['from_city_id']);
            $table->dropForeign(['to_city_id']);
            $table->dropColumn(['airline_id', 'from_city_id', 'to_city_id', 'is_active', 'available_seats']);
        });
    }
};
