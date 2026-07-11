<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Site;
use App\Models\DailyLabourSupply;
use App\Models\PaymentRecord;
use App\Models\Expense;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\FeaturedClient;
use App\Models\Career;
use App\Models\CompanySetting;
use App\Enums\UserRole;
use App\Enums\PaymentHead;
use App\Enums\PaymentMethod;
use App\Enums\ExpenseCategory;
use App\Enums\Shift;
use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Super Admin
        User::create([
            'name' => 'Ashutosh Admin',
            'email' => 'admin@ashutoshenterprises.com',
            'password' => Hash::make('password'),
            'role' => UserRole::SUPER_ADMIN,
            'phone' => '9876543210',
            'is_active' => true,
        ]);

        // 2. Company Settings
        $settings = [
            ['key' => 'Company Name', 'value' => 'Ashutosh Enterprises', 'group' => 'general'],
            ['key' => 'Email', 'value' => 'info@ashutoshenterprises.com', 'group' => 'contact'],
            ['key' => 'Phone', 'value' => '+91 98765 43210', 'group' => 'contact'],
            ['key' => 'Address', 'value' => '123 Business Park, Industrial Area, New Delhi - 110001', 'group' => 'contact'],
            ['key' => 'GSTIN', 'value' => '07AABCA1234Z1Z5', 'group' => 'invoice'],
            ['key' => 'Facebook URL', 'value' => '#', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            CompanySetting::create($setting);
        }

        // 3. Public Site Data
        Service::insert([
            ['title' => 'Skilled Labour', 'slug' => 'skilled-labour', 'short_description' => 'Certified and experienced technicians.', 'description' => 'We provide highly skilled labour including electricians, plumbers, welders, and fitters for specialized tasks.', 'icon' => 'bi-tools', 'is_active' => true, 'sort_order' => 1],
            ['title' => 'Semi-Skilled Labour', 'slug' => 'semi-skilled-labour', 'short_description' => 'Assisting workforce for operations.', 'description' => 'Dependable semi-skilled workers to assist your core operations and maintain efficiency on site.', 'icon' => 'bi-person-gear', 'is_active' => true, 'sort_order' => 2],
            ['title' => 'Unskilled Labour', 'slug' => 'unskilled-labour', 'short_description' => 'General purpose workforce.', 'description' => 'Hardworking general labour for loading, unloading, shifting, cleaning, and manual assistance.', 'icon' => 'bi-people', 'is_active' => true, 'sort_order' => 3],
        ]);

        Faq::insert([
            ['question' => 'How fast can you deploy labour?', 'answer' => 'We can typically deploy the required workforce within 24 to 48 hours of finalizing the agreement.', 'is_active' => true, 'sort_order' => 1],
            ['question' => 'Are your workers verified?', 'answer' => 'Yes, every worker undergoes a strict verification process including identity checks and past experience verification.', 'is_active' => true, 'sort_order' => 2],
            ['question' => 'Do you handle PF and ESI compliances?', 'answer' => 'Absolutely. We ensure 100% compliance with all statutory requirements including PF, ESI, and minimum wages.', 'is_active' => true, 'sort_order' => 3],
        ]);

        Testimonial::insert([
            ['client_name' => 'Rajesh Sharma', 'company' => 'L&T Construction', 'content' => 'Ashutosh Enterprises has been our reliable partner for over 3 years. Their workforce is punctual and well-trained.', 'rating' => 5, 'is_active' => true, 'sort_order' => 1],
            ['client_name' => 'Vikram Singh', 'company' => 'Tata Projects', 'content' => 'Highly professional service. They handled a sudden requirement of 200 workers seamlessly.', 'rating' => 5, 'is_active' => true, 'sort_order' => 2],
        ]);

        FeaturedClient::insert([
            ['name' => 'L&T Construction', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Tata Projects', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Reliance Infrastructure', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'DLF Limited', 'is_active' => true, 'sort_order' => 4],
        ]);

        Career::insert([
            ['title' => 'Site Supervisor', 'location' => 'Delhi NCR', 'type' => 'full-time', 'description' => 'Looking for experienced site supervisors with minimum 5 years in managing construction manpower.', 'is_active' => true],
            ['title' => 'HR Executive', 'location' => 'New Delhi', 'type' => 'full-time', 'description' => 'HR Executive required to manage payroll, compliance, and labour relations.', 'is_active' => true],
        ]);

        // 4. Clients and Sites
        $client1 = Client::create([
            'company_name' => 'Alpha Builders', 'contact_person' => 'Amit Kumar', 'mobile' => '9811000001', 'email' => 'amit@alphabuilders.com', 'status' => Status::ACTIVE,
        ]);
        $client2 = Client::create([
            'company_name' => 'Omega Logistics', 'contact_person' => 'Sunil Verma', 'mobile' => '9811000002', 'email' => 'sunil@omegalogistics.com', 'status' => Status::ACTIVE,
        ]);

        $site1 = Site::create(['client_id' => $client1->id, 'site_name' => 'Tower A Construction', 'address' => 'Gurugram Sector 62', 'status' => Status::ACTIVE]);
        $site2 = Site::create(['client_id' => $client1->id, 'site_name' => 'Tower B Extension', 'address' => 'Gurugram Sector 62', 'status' => Status::ACTIVE]);
        $site3 = Site::create(['client_id' => $client2->id, 'site_name' => 'Warehouse Facility', 'address' => 'Manesar Industrial Area', 'status' => Status::ACTIVE]);

        // 5. Labour Supply Entries (Last 30 days)
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            
            // Site 1
            DailyLabourSupply::create([
                'client_id' => $client1->id, 'site_id' => $site1->id, 'date' => $date, 'skilled_count' => rand(5, 10), 'semi_skilled_count' => rand(10, 20), 'unskilled_count' => rand(20, 50), 'total_count' => 0, 'shift' => Shift::DAY,
            ]);
            // Site 3
            DailyLabourSupply::create([
                'client_id' => $client2->id, 'site_id' => $site3->id, 'date' => $date, 'skilled_count' => 0, 'semi_skilled_count' => rand(5, 15), 'unskilled_count' => rand(30, 60), 'total_count' => 0, 'shift' => Shift::NIGHT,
            ]);
        }
        // Force calculation
        foreach(DailyLabourSupply::all() as $ls) {
            $ls->update(['total_count' => $ls->skilled_count + $ls->semi_skilled_count + $ls->unskilled_count + $ls->other_count]);
        }

        // 6. Payments
        PaymentRecord::create(['client_id' => $client1->id, 'site_id' => $site1->id, 'date' => Carbon::today()->subDays(15), 'payment_head' => PaymentHead::ADVANCE, 'amount' => 50000, 'payment_method' => PaymentMethod::BANK, 'reference_number' => 'NEFT-12345']);
        PaymentRecord::create(['client_id' => $client1->id, 'site_id' => $site1->id, 'date' => Carbon::today()->subDays(5), 'payment_head' => PaymentHead::GROUP, 'amount' => 150000, 'payment_method' => PaymentMethod::CHEQUE, 'reference_number' => 'CHQ-987654']);

        // 7. Expenses
        Expense::create(['date' => Carbon::today()->subDays(10), 'category' => ExpenseCategory::OFFICE, 'amount' => 5000, 'vendor' => 'Stationery Mart', 'description' => 'Office supplies']);
        Expense::create(['date' => Carbon::today()->subDays(2), 'category' => ExpenseCategory::TRAVEL, 'amount' => 1200, 'vendor' => 'Uber', 'description' => 'Site visit travel']);
    }
}
