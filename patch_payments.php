<?php

use Illuminate\Support\Facades\DB;
use App\Models\PaymentRecord;
use App\Models\Expense;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$headsToMigrate = [
    'group' => 'group_labour',
    'single_labour' => 'single_labour',
    'accommodation' => 'accommodation',
    'transportation' => 'transportation',
    'food' => 'food'
];

$migrated = 0;

foreach ($headsToMigrate as $paymentHead => $expenseCategory) {
    // We cannot use Eloquent if the enum case is deleted, so we use DB query builder
    $records = DB::table('payment_records')->where('payment_head', $paymentHead)->get();
    
    foreach ($records as $record) {
        $client = DB::table('clients')->where('id', $record->client_id)->first();
        $vendorName = $client ? $client->company_name . ' (Labour/Site)' : 'Unknown Vendor';
        
        DB::table('expenses')->insert([
            'date' => $record->date,
            'category' => $expenseCategory,
            'vendor' => $vendorName,
            'description' => $record->remarks ?? 'Migrated from Payments',
            'amount' => $record->amount,
            'created_at' => $record->created_at,
            'updated_at' => $record->updated_at,
        ]);
        
        DB::table('payment_records')->where('id', $record->id)->delete();
        $migrated++;
    }
}

echo "Successfully migrated $migrated records from Payments to Expenses.\n";

// Also update any 'advance' to 'advance_from_client'
$advanced = DB::table('payment_records')->where('payment_head', 'advance')->update(['payment_head' => 'advance_from_client']);
echo "Updated $advanced 'advance' payments to 'advance_from_client'.\n";

