<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CompanySetting;

CompanySetting::where('key', 'Company_Name')->delete();

$newSettings = [
    ['key' => 'Bank Name', 'value' => '', 'group' => 'invoice'],
    ['key' => 'Account Number', 'value' => '', 'group' => 'invoice'],
    ['key' => 'IFSC Code', 'value' => '', 'group' => 'invoice'],
    ['key' => 'Company PAN', 'value' => '', 'group' => 'invoice'],
    ['key' => 'Invoice Prefix', 'value' => 'AE-', 'group' => 'invoice'],
    ['key' => 'Default Payment Terms', 'value' => 'Net 30 Days', 'group' => 'invoice'],
    ['key' => 'Company Logo', 'value' => '', 'group' => 'general'],
    ['key' => 'Favicon', 'value' => '', 'group' => 'general'],
    ['key' => 'Default Shift Timings', 'value' => '09:00 AM to 06:00 PM', 'group' => 'general'],
    ['key' => 'Support Email', 'value' => '', 'group' => 'contact'],
    ['key' => 'LinkedIn URL', 'value' => '', 'group' => 'social'],
    ['key' => 'Website URL', 'value' => '', 'group' => 'social'],
    ['key' => 'Instagram URL', 'value' => '', 'group' => 'social'],
];

foreach ($newSettings as $ns) {
    if (!CompanySetting::where('key', $ns['key'])->exists()) {
        CompanySetting::create($ns);
    }
}
echo "Settings successfully patched.\n";
