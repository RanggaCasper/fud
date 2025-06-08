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
        Schema::create('restaurant_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->longText('comment')->nullable();
            $table->enum('source', ['user', 'google']);
            $table->string('link')->nullable();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_review_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->enum('status', ['pending', 'resolved', 'reviewed'])->default('pending');
            $table->foreignId('restaurant_review_id')->constrained('restaurant_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_review_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_review_id')->constrained('restaurant_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('restaurant_review_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_review_id')->constrained('restaurant_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('restaurant_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->enum('type', ['image', 'video']);
            $table->foreignId('restaurant_review_id')->constrained('restaurant_reviews')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reviews');
        Schema::dropIfExists('restaurant_review_reports');
        Schema::dropIfExists('restaurant_review_likes');
        Schema::dropIfExists('restaurant_review_replies');
        Schema::dropIfExists('restaurant_attachments');
    }
};
