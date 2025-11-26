<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\Wphcp\BackupSiteJob;
use App\Jobs\Wphcp\CreateWordpressSiteJob;
use App\Models\Site;
use App\Services\Wphcp\SiteProvisioningService;
use App\Services\Wphcp\SslService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SiteWebController extends Controller
{
    public function __construct(
        private readonly SiteProvisioningService $provisioningService,
        private readonly SslService $sslService
    ) {
    }

    public function index(): View
    {
        $sites = Site::with(['database', 'sslCertificate'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sites.index', ['sites' => $sites]);
    }

    public function create(): View
    {
        return view('sites.create');
    }

    public function store(Request $request): RedirectResponse
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

        Log::info('Site creation job dispatched from web', ['site_id' => $site->id]);

        return redirect()->route('sites.show', $site)
            ->with('success', 'Site creation has been queued. Please wait for provisioning to complete.');
    }

    public function show(Site $site): View
    {
        $site->load(['database', 'backups', 'sslCertificate']);

        return view('sites.show', ['site' => $site]);
    }

    public function toggleMaintenance(Request $request, Site $site): RedirectResponse
    {
        $enabled = $request->boolean('enabled');

        try {
            $this->provisioningService->toggleMaintenanceMode($site, $enabled);

            return redirect()->back()->with('success', 'Maintenance mode updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to toggle maintenance mode: ' . $e->getMessage());
        }
    }

    public function resetAdminPassword(Request $request, Site $site): RedirectResponse
    {
        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        try {
            $this->provisioningService->resetAdminPassword($site, $validated['new_password']);

            return redirect()->back()->with('success', 'Admin password reset successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reset admin password: ' . $e->getMessage());
        }
    }

    public function createBackup(Site $site): RedirectResponse
    {
        BackupSiteJob::dispatch($site->id, 'manual');

        return redirect()->back()->with('success', 'Backup job has been queued.');
    }

    public function requestSsl(Site $site): RedirectResponse
    {
        try {
            $this->sslService->requestCertificate($site);

            return redirect()->back()->with('success', 'SSL certificate requested successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to request SSL certificate: ' . $e->getMessage());
        }
    }
}


