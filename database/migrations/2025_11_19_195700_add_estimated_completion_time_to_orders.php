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
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('estimated_completion_at')->nullable()->after('completed_at');
            $table->dateTime('actual_completion_at')->nullable()->after('estimated_completion_at');
            $table->decimal('subtotal', 10, 2)->default(0)->after('total_price');
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('additional_charges', 10, 2)->default(0)->after('discount');
            $table->string('order_number')->unique()->nullable()->after('id');
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['estimated_completion_at', 'actual_completion_at', 'subtotal', 'discount', 'additional_charges', 'order_number']);
        });
    }
};
