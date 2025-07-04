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
        Schema::create('point_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('target_points');
            $table->timestamps();
        });

        Schema::create('point_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);
            $table->string('action');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_levels');
        Schema::dropIfExists('point_logs');
    }
};
