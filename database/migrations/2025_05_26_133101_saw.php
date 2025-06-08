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
        Schema::create('saw_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['benefit', 'cost']);
            $table->timestamps();
        });

        Schema::create('saw_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saw_criteria_id')->constrained('saw_criteria')->onDelete('cascade');
            $table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saw_weights');
        Schema::dropIfExists('saw_criteria');
    }
};
