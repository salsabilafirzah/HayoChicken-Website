<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

$orders = Order::all();
foreach ($orders as $order) {
    if (str_starts_with($order->order_number, 'HAYO-')) {
        $date = $order->created_at->format('Ymd');
        $newNumber = 'HC-' . $date . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $order->update(['order_number' => $newNumber]);
        echo "Updated order {$order->id} to {$newNumber}\n";
    }
}
echo "Migration complete!";
