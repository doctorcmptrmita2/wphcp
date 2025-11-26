<?php

declare(strict_types=1);

namespace App\Jobs\Wphcp;

use App\Models\Site;
use App\Services\Wphcp\BackupService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class BackupSiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public readonly int $siteId,
        public readonly string $type = 'manual'
    ) {
    }

    public function handle(BackupService $backupService): void
    {
        $site = Site::findOrFail($this->siteId);

        Log::info('Starting backup job', [
            'site_id' => $this->siteId,
            'domain' => $site->domain,
            'type' => $this->type,
        ]);

        try {
            $backupService->createBackup($site, $this->type);

            Log::info('Backup job completed successfully', [
                'site_id' => $this->siteId,
            ]);
        } catch (Throwable $e) {
            Log::error('Backup job failed', [
                'site_id' => $this->siteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error('BackupSiteJob failed permanently', [
            'site_id' => $this->siteId,
            'error' => $exception->getMessage(),
        ]);
    }
}


