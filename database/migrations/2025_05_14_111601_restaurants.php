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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->float('latitude');
            $table->float('longitude');
            $table->string('rating')->nullable();
            $table->string('reviews')->nullable();
            $table->string('price_range')->nullable();
            $table->timestamps();
        });

        Schema::create('restaurant_operating_hours', function (Blueprint $table) {
            $table->id();
            $table->enum('day', [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ]);
            $table->string('operating_hours')->nullable();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_offerings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('restaurant_operating_hours');
        Schema::dropIfExists('restaurant_offerings');
    }
};
