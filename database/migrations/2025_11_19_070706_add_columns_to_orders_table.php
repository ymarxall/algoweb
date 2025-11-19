<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('customer_name')->after('table_id');
        $table->string('payment_method')->after('customer_name'); // ovo, gopay, cash, dll
        $table->integer('estimated_minutes')->nullable()->after('payment_method'); // estimasi dalam menit
        $table->enum('status', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])
              ->default('pending')->change(); // perlu package doctrine/dbal kalau ganti enum
        $table->timestamp('completed_at')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['customer_name', 'payment_method', 'estimated_minutes', 'completed_at']);
        // untuk enum revert butuh effort lebih
    });
}
};
