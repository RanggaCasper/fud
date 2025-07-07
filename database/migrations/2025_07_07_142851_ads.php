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
            $table->string('name', 255);
            $table->enum('type', ['carousel', 'restaurant']);
            $table->double('base_price');
            $table->timestamps();
        });

        Schema::create('restaurant_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ads_type_id')->constrained('ads_types')->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->double('total_cost')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('run_length');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('ads_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->foreignId('restaurant_ad_id')->constrained('restaurant_ads')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_ad_id')->constrained('restaurant_ads')->onDelete('cascade');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('reference')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_types');
        Schema::dropIfExists('restaurant_ads');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('ads_clicks');
    }
};
