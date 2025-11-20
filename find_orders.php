<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Order;
$rows = Order::where('status','accepted')->take(10)->get();
if($rows->count()===0){
    echo "No accepted orders\n";
} else {
    foreach($rows as $o){
        echo $o->id.' '.$o->order_number.' status='.$o->status.' estimated='.$o->estimated_completion_at."\n";
    }
}
