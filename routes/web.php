<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SiteWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public pages
Route::get('/about', [\App\Http\Controllers\Web\PageController::class, 'about'])->name('pages.about');
Route::get('/who-we-are', [\App\Http\Controllers\Web\PageController::class, 'whoWeAre'])->name('pages.who-we-are');
Route::get('/contact', [\App\Http\Controllers\Web\PageController::class, 'contact'])->name('pages.contact');
Route::get('/roadmap', [\App\Http\Controllers\Web\PageController::class, 'roadmap'])->name('pages.roadmap');
Route::get('/privacy', [\App\Http\Controllers\Web\PageController::class, 'privacy'])->name('pages.privacy');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sites routes
    Route::resource('sites', SiteWebController::class);
    Route::post('sites/{site}/maintenance-toggle', [SiteWebController::class, 'toggleMaintenance'])->name('sites.maintenance-toggle');
    Route::post('sites/{site}/reset-password', [SiteWebController::class, 'resetAdminPassword'])->name('sites.reset-password');
    Route::post('sites/{site}/backup', [SiteWebController::class, 'createBackup'])->name('sites.backup');
    Route::post('sites/{site}/ssl-request', [SiteWebController::class, 'requestSsl'])->name('sites.ssl-request');
    
    // DNS routes
    Route::get('sites/{site}/dns', [\App\Http\Controllers\Web\DnsController::class, 'index'])->name('sites.dns');
    Route::post('sites/{site}/dns', [\App\Http\Controllers\Web\DnsController::class, 'store'])->name('sites.dns.store');
    Route::put('sites/{site}/dns/{dnsRecord}', [\App\Http\Controllers\Web\DnsController::class, 'update'])->name('sites.dns.update');
    Route::delete('sites/{site}/dns/{dnsRecord}', [\App\Http\Controllers\Web\DnsController::class, 'destroy'])->name('sites.dns.destroy');
    
    // Database Management routes
    Route::get('sites/{site}/database', [\App\Http\Controllers\Web\DatabaseManagementController::class, 'index'])->name('sites.database');
    Route::post('sites/{site}/database/query', [\App\Http\Controllers\Web\DatabaseManagementController::class, 'executeQuery'])->name('sites.database.query');
    Route::get('sites/{site}/database/tables', [\App\Http\Controllers\Web\DatabaseManagementController::class, 'showTables'])->name('sites.database.tables');
    Route::get('sites/{site}/database/table/{tableName}', [\App\Http\Controllers\Web\DatabaseManagementController::class, 'showTableStructure'])->name('sites.database.table');
    Route::get('sites/{site}/database/phpmyadmin', [\App\Http\Controllers\Web\DatabaseManagementController::class, 'phpmyadmin'])->name('sites.database.phpmyadmin');
    
    // Site Settings routes
    Route::get('sites/{site}/settings', [\App\Http\Controllers\Web\SiteSettingsController::class, 'index'])->name('sites.settings');
    Route::put('sites/{site}/settings', [\App\Http\Controllers\Web\SiteSettingsController::class, 'update'])->name('sites.settings.update');
});

require __DIR__.'/auth.php';
