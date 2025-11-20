<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
$rows = Order::whereNotNull('estimated_completion_at')->orderBy('id','desc')->take(10)->get();
if($rows->count()===0){
    echo "No orders with estimated_completion_at found\n";
} else {
    foreach($rows as $o){
        echo $o->id.' '.$o->order_number.' => '.($o->estimated_completion_at ? $o->estimated_completion_at : 'NULL')."\n";
    }
}
