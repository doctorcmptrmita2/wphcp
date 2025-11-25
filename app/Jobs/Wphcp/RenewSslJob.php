<?php

declare(strict_types=1);

namespace App\Jobs\Wphcp;

use App\Models\Site;
use App\Services\Wphcp\SslService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class RenewSslJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public readonly int $siteId
    ) {
    }

    public function handle(SslService $sslService): void
    {
        $site = Site::findOrFail($this->siteId);

        Log::info('Starting SSL renewal job', [
            'site_id' => $this->siteId,
            'domain' => $site->domain,
        ]);

        try {
            $sslService->renewCertificate($site);

            Log::info('SSL renewal job completed successfully', [
                'site_id' => $this->siteId,
            ]);
        } catch (Throwable $e) {
            Log::error('SSL renewal job failed', [
                'site_id' => $this->siteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error('RenewSslJob failed permanently', [
            'site_id' => $this->siteId,
            'error' => $exception->getMessage(),
        ]);
    }
}

