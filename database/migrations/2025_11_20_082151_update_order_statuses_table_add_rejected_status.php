<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_statuses', function (Blueprint $table) {
            // Modify status column to include 'rejected' in enum
            if (DB::getDriverName() === 'sqlite') {
                // SQLite doesn't support altering enum, so we skip
            } else {
                $table->enum('status', ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled', 'rejected'])->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_statuses', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->enum('status', ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled'])->change();
            }
        });
    }
};
