<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('location', 100);
            $table->string('image', 500)->nullable();
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->integer('reviews')->default(0);
            $table->decimal('price', 10, 2);
            $table->json('amenities')->nullable();
            $table->string('category', 50)->nullable();
            $table->text('description')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
