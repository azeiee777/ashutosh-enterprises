<?php

use Illuminate\Support\Facades\Route;

// Public Website Routes
use App\Http\Controllers\Web\PublicSite\HomeController;
use App\Http\Controllers\Web\PublicSite\AboutController;
use App\Http\Controllers\Web\PublicSite\ServiceController;
use App\Http\Controllers\Web\PublicSite\ClientShowcaseController;
use App\Http\Controllers\Web\PublicSite\GalleryController;
use App\Http\Controllers\Web\PublicSite\CareerController;
use App\Http\Controllers\Web\PublicSite\ContactController;

// Auth Routes
use App\Http\Controllers\Auth\LoginController;

// Admin Routes
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\ClientController;
use App\Http\Controllers\Web\Admin\SiteController;
use App\Http\Controllers\Web\Admin\DailyLabourSupplyController;
use App\Http\Controllers\Web\Admin\PaymentRecordController;
use App\Http\Controllers\Web\Admin\ExpenseController;
use App\Http\Controllers\Web\Admin\ReportController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\SettingController;
use App\Http\Controllers\Web\Admin\SearchController;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/clients', [ClientShowcaseController::class, 'index'])->name('clients.showcase');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::post('/careers/apply', [CareerController::class, 'apply'])->name('careers.apply');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// SEO Sitemap
Route::get('/sitemap.xml', function () {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $routes = ['home', 'about', 'services.index', 'clients.showcase', 'gallery', 'careers.index', 'contact'];
    foreach ($routes as $route) {
        $xml .= '<url>';
        $xml .= '<loc>' . route($route) . '</loc>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>' . ($route === 'home' ? '1.0' : '0.8') . '</priority>';
        $xml .= '</url>';
    }
    // Dynamic services
    $services = \App\Models\Service::where('is_active', true)->get();
    foreach ($services as $service) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('services.show', $service->slug) . '</loc>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.7</priority>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';
    
    return response($xml, 200)->header('Content-Type', 'text/xml');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Client Management
    Route::resource('clients', ClientController::class);

    // Site Management
    Route::resource('sites', SiteController::class);

    // Daily Labour Supply
    Route::get('labour-supply/export', [DailyLabourSupplyController::class, 'export'])->name('labour-supply.export');
    Route::get('labour-supply/export-pdf', [DailyLabourSupplyController::class, 'exportPdf'])->name('labour-supply.export_pdf');
    Route::resource('labour-supply', DailyLabourSupplyController::class)
        ->parameters(['labour-supply' => 'labourSupply']);

    // Payment Records
    Route::get('payments/export', [PaymentRecordController::class, 'export'])->name('payments.export');
    Route::get('payments/export-pdf', [PaymentRecordController::class, 'exportPdf'])->name('payments.export_pdf');
    Route::resource('payments', PaymentRecordController::class)
        ->parameters(['payments' => 'payment']);

    // Expense Management
    Route::get('expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('expenses/export-pdf', [ExpenseController::class, 'exportPdf'])->name('expenses.export_pdf');
    Route::resource('expenses', ExpenseController::class);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports', [ReportController::class, 'generate'])->name('reports.generate');
    Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::post('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export_pdf');

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Global Search
    Route::get('search', [SearchController::class, 'index'])->name('search');

    // API: Get sites by client (AJAX)
    Route::get('api/sites-by-client/{client}', function (App\Models\Client $client) {
        return response()->json($client->sites()->active()->get(['id', 'site_name']));
    })->name('api.sites-by-client');
});
