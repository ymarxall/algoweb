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
            // Add missing columns for checkout and order management
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->nullable()->index()->after('id');
            }
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'additional_charges')) {
                $table->decimal('additional_charges', 10, 2)->default(0)->after('discount');
            }
            if (!Schema::hasColumn('orders', 'final_total')) {
                $table->decimal('final_total', 10, 2)->nullable()->after('additional_charges');
            }
            if (!Schema::hasColumn('orders', 'estimated_minutes')) {
                $table->integer('estimated_minutes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'estimated_completion_at')) {
                $table->timestamp('estimated_completion_at')->nullable()->after('estimated_minutes');
            }
            if (!Schema::hasColumn('orders', 'actual_completion_at')) {
                $table->timestamp('actual_completion_at')->nullable()->after('estimated_completion_at');
            }
            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('actual_completion_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop columns if they exist
            $columnsToDropIfExist = [
                'order_number', 'customer_name', 'payment_method', 'subtotal',
                'discount', 'additional_charges', 'final_total', 'estimated_minutes',
                'estimated_completion_at', 'actual_completion_at', 'snap_token'
            ];
            
            foreach ($columnsToDropIfExist as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
