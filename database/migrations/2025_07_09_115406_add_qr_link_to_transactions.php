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
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('price')->after('restaurant_ad_id')->nullable();
            $table->double('fee')->after('price')->nullable();
            $table->double('total')->after('fee')->nullable();
            $table->string('qr_link')->after('reference')->nullable();
            $table->json('order_details')->after('qr_link')->nullable();
            $table->timestamp('expired_at')->after('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('fee');
            $table->dropColumn('total');
            $table->dropColumn('qr_link');
            $table->dropColumn('order_details');
            $table->dropColumn('expired_at');
        });
    }
};
