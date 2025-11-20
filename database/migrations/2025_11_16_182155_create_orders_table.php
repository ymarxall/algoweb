<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Untuk guest bisa null
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade'); // Relasi ke meja
            // Identifiers & customer info
            $table->string('order_number')->nullable()->index();
            $table->string('customer_name')->nullable();
            $table->string('payment_method')->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0); // Total harga
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2)->nullable();

            // Status / timings
            $table->integer('estimated_minutes')->nullable();
            $table->timestamp('estimated_completion_at')->nullable();
            $table->timestamp('actual_completion_at')->nullable();

            $table->enum('status', ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled'])->default('pending');
            $table->string('snap_token')->nullable(); // Untuk Midtrans payment
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};