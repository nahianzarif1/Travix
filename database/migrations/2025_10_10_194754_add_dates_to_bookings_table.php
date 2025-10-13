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
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('booking_date')->nullable()->after('amount');
            $table->date('travel_date')->nullable()->after('booking_date');
            $table->date('check_in_date')->nullable()->after('travel_date');
            $table->date('check_out_date')->nullable()->after('check_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_date', 'travel_date', 'check_in_date', 'check_out_date']);
        });
    }
};
