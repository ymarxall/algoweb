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
        Schema::table('orders', function (Blueprint $table) {
            // Modify status enum to include 'rejected' (SQLite doesn't support enum modification directly, so we use raw SQL)
            // For SQLite compatibility, we'll use a workaround if needed
            if (DB::getDriverName() === 'sqlite') {
                // SQLite doesn't support altering enum, so we skip this in SQLite
                // The 'rejected' value can still be inserted as it's just text
            } else {
                // For MySQL/PostgreSQL
                $table->enum('status', ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled', 'rejected'])
                    ->default('pending')
                    ->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->enum('status', ['pending', 'accepted', 'preparing', 'ready', 'completed', 'cancelled'])
                    ->default('pending')
                    ->change();
            }
        });
    }
};
