<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image', 500)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('duration', 50)->nullable();
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->integer('reviews')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->json('highlights')->nullable();
            $table->json('includes')->nullable();
            $table->string('group_size', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};


