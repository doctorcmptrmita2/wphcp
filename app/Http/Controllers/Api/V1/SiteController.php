<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\Wphcp\BackupSiteJob;
use App\Jobs\Wphcp\CreateWordpressSiteJob;
use App\Models\Site;
use App\Services\Wphcp\SiteProvisioningService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{
    public function __construct(
        private readonly SiteProvisioningService $provisioningService
    ) {
    }

    public function index(): JsonResponse
    {
        $sites = Site::with(['database', 'sslCertificate'])
            ->select('id', 'domain', 'status', 'php_version', 'last_backup_at', 'created_at')
            ->get();

        return response()->json($sites);
    }

    public function show(Site $site): JsonResponse
    {
        $site->load(['database', 'sslCertificate']);

        return response()->json([
            'id' => $site->id,
            'domain' => $site->domain,
            'root_path' => $site->root_path,
            'php_version' => $site->php_version,
            'status' => $site->status,
            'maintenance_mode' => $site->maintenance_mode,
            'last_backup_at' => $site->last_backup_at,
            'database' => $site->database ? [
                'id' => $site->database->id,
                'name' => $site->database->name,
                'username' => $site->database->username,
                'host' => $site->database->host,
                'port' => $site->database->port,
            ] : null,
            'ssl_certificate' => $site->sslCertificate ? [
                'status' => $site->sslCertificate->status,
                'expires_at' => $site->sslCertificate->expires_at,
            ] : null,
            'created_at' => $site->created_at,
            'updated_at' => $site->updated_at,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'domain' => [
                'required',
                'string',
                'regex:/^[a-z0-9.-]+$/i',
                'unique:sites,domain',
            ],
            'site_title' => ['required', 'string', 'max:255'],
            'admin_username' => ['required', 'string', 'min:3', 'max:60'],
            'admin_email' => ['required', 'email'],
            'admin_password' => ['required', 'string', 'min:8'],
            'php_version' => ['nullable', 'string'],
        ]);

        $site = Site::create([
            'domain' => $validated['domain'],
            'root_path' => config('wphcp.web_root_base') . '/' . $validated['domain'],
            'php_version' => $validated['php_version'] ?? config('wphcp.default_php_version'),
            'status' => 'creating',
        ]);

        CreateWordpressSiteJob::dispatch(
            domain: $validated['domain'],
            siteTitle: $validated['site_title'],
            adminUsername: $validated['admin_username'],
            adminEmail: $validated['admin_email'],
            adminPassword: $validated['admin_password'],
            phpVersion: $validated['php_version'] ?? null
        );

        Log::info('Site creation job dispatched', ['site_id' => $site->id]);

        return response()->json($site, 201);
    }

    public function toggleMaintenance(Request $request, Site $site): JsonResponse
    {
        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        try {
            $this->provisioningService->toggleMaintenanceMode($site, $validated['enabled']);

            return response()->json([
                'message' => 'Maintenance mode updated',
                'maintenance_mode' => $site->maintenance_mode,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to toggle maintenance mode',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function resetAdminPassword(Request $request, Site $site): JsonResponse
    {
        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        try {
            $this->provisioningService->resetAdminPassword($site, $validated['new_password']);

            return response()->json([
                'message' => 'Admin password reset successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to reset admin password',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createBackup(Request $request, Site $site): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['nullable', Rule::in(['manual', 'auto'])],
        ]);

        BackupSiteJob::dispatch(
            siteId: $site->id,
            type: $validated['type'] ?? 'manual'
        );

        return response()->json([
            'message' => 'Backup job has been queued',
            'site_id' => $site->id,
        ]);
    }

    public function listBackups(Site $site): JsonResponse
    {
        $backups = $site->backups()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($backups);
    }
}

