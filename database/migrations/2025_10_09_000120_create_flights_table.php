<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline', 100);
            $table->string('aircraft', 50)->nullable();
            $table->string('from_city', 50);
            $table->string('to_city', 50);
            $table->time('departure');
            $table->time('arrival');
            $table->string('duration', 20)->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->json('amenities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
