<?php

use App\Http\Controllers\Api\V1\BackupController;
use App\Http\Controllers\Api\V1\DatabaseController;
use App\Http\Controllers\Api\V1\SiteController;
use App\Http\Controllers\Api\V1\SslController;
use App\Http\Controllers\Api\V1\SystemController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('sites', SiteController::class);
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

