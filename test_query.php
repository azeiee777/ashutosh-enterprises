<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DailyLabourSupply;
use Illuminate\Http\Request;

$req = Request::create('/admin/labour-supply', 'GET', [
    'date_from' => '2026-07-11',
    'date_to' => '2026-07-11',
    'client_id' => null
]);

$q = DailyLabourSupply::with(['client', 'site'])
    ->when($req->input('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
    ->when($req->input('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
    ->when($req->input('client_id'), fn($q, $c) => $q->byClient($c))
    ->orderBy('date', 'desc');

echo $q->toSql() . "\n";
echo "Bindings: " . json_encode($q->getBindings()) . "\n";
echo "Count: " . $q->count() . "\n";

echo "test-deployment"
