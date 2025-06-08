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
        Schema::create('ads_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('source', 255);
            $table->enum('type', ['video', 'image']);
            $table->double('price');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('ads_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->foreignId('ad_id')->constrained('ads_types')->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ads_views', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->foreignId('ad_id')->constrained('ads_types')->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('ad_id')->constrained('ads_types')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('total_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_ads');
        Schema::dropIfExists('ads_views');
        Schema::dropIfExists('ads_clicks');
        Schema::dropIfExists('ads_types');
    }
};
