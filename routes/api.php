<?php

use App\Http\Controllers\Api\V1\BackupController;
use App\Http\Controllers\Api\V1\DatabaseController;
use App\Http\Controllers\Api\V1\SiteController;
use App\Http\Controllers\Api\V1\SslController;
use App\Http\Controllers\Api\V1\SystemController;
use Illuminate\Support\Facades\Route;

// Redirect browser requests from API to web interface
Route::prefix('v1')->group(function () {
    Route::get('sites', function () {
        if (request()->wantsJson() === false && request()->acceptsHtml()) {
            return redirect()->route('sites.index');
        }
    });
    
    Route::get('sites/{site}', function (\App\Models\Site $site) {
        if (request()->wantsJson() === false && request()->acceptsHtml()) {
            return redirect()->route('sites.show', $site);
        }
    });
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('sites', SiteController::class)->names([
        'index' => 'api.v1.sites.index',
        'show' => 'api.v1.sites.show',
        'store' => 'api.v1.sites.store',
        'update' => 'api.v1.sites.update',
        'destroy' => 'api.v1.sites.destroy',
    ]);
    Route::post('sites/{site}/maintenance-toggle', [SiteController::class, 'toggleMaintenance']);
    Route::post('sites/{site}/reset-admin-password', [SiteController::class, 'resetAdminPassword']);
    Route::post('sites/{site}/backup', [SiteController::class, 'createBackup']);
    Route::get('sites/{site}/backups', [SiteController::class, 'listBackups']);

    Route::apiResource('databases', DatabaseController::class);
    Route::apiResource('backups', BackupController::class);
    Route::get('backups/{backup}/download', [BackupController::class, 'download']);

    Route::get('ssl', [SslController::class, 'index']);
    Route::post('sites/{site}/ssl/request', [SslController::class, 'request']);
    Route::post('sites/{site}/ssl/renew', [SslController::class, 'renew']);

    Route::get('system/dashboard', [SystemController::class, 'dashboard']);
});

