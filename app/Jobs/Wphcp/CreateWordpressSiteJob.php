<?php

declare(strict_types=1);

namespace App\Jobs\Wphcp;

use App\Data\Wphcp\SiteProvisioningData;
use App\Models\Site;
use App\Services\Wphcp\DatabaseService;
use App\Services\Wphcp\SiteProvisioningService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateWordpressSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public readonly string $domain,
        public readonly string $siteTitle,
        public readonly string $adminUsername,
        public readonly string $adminEmail,
        public readonly string $adminPassword,
        public readonly ?string $phpVersion = null
    ) {
    }

    public function handle(
        DatabaseService $databaseService,
        SiteProvisioningService $provisioningService
    ): void {
        Log::info('Starting WordPress site creation job', [
            'domain' => $this->domain,
        ]);

        try {
            // Find or create Site record
            $site = Site::firstOrCreate(
                ['domain' => $this->domain],
                [
                    'root_path' => config('wphcp.web_root_base') . '/' . $this->domain,
                    'php_version' => $this->phpVersion ?? config('wphcp.default_php_version'),
                    'status' => 'creating',
                ]
            );

            // Create database
            $database = $databaseService->createDatabaseForDomain($this->domain);

            // Provision site
            $provisioningData = new SiteProvisioningData(
                domain: $this->domain,
                siteTitle: $this->siteTitle,
                adminUsername: $this->adminUsername,
                adminEmail: $this->adminEmail,
                adminPassword: $this->adminPassword,
                phpVersion: $this->phpVersion
            );

            $provisioningService->provisionSite($provisioningData, $database, $site);

            // Update site with database association
            $site->refresh();
            $site->update(['db_id' => $database->id]);

            Log::info('WordPress site creation completed successfully', [
                'site_id' => $site->id,
                'domain' => $this->domain,
            ]);
        } catch (Throwable $e) {
            Log::error('WordPress site creation failed', [
                'domain' => $this->domain,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Update site status to error
            $site = Site::where('domain', $this->domain)->first();
            if ($site) {
                $site->update(['status' => 'error']);
            }

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error('CreateWordpressSiteJob failed permanently', [
            'domain' => $this->domain,
            'error' => $exception->getMessage(),
        ]);

        $site = Site::where('domain', $this->domain)->first();
        if ($site) {
            $site->update(['status' => 'error']);
        }
    }
}

