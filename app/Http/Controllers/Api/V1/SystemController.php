<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\Site;
use App\Models\SslCertificate;
use Illuminate\Http\JsonResponse;

class SystemController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $totalSites = Site::count();
        $activeSites = Site::where('status', 'active')->count();
        $errorSites = Site::where('status', 'error')->count();
        $totalBackups = Backup::count();
        $sitesWithoutSsl = Site::whereDoesntHave('sslCertificate')->count();

        $nextExpiringCertificates = SslCertificate::where('status', 'active')
            ->whereNotNull('expires_at')
            ->orderBy('expires_at', 'asc')
            ->limit(5)
            ->with('site')
            ->get()
            ->map(function ($cert) {
                return [
                    'site_id' => $cert->site_id,
                    'domain' => $cert->domain,
                    'expires_at' => $cert->expires_at,
                ];
            });

        return response()->json([
            'total_sites' => $totalSites,
            'active_sites' => $activeSites,
            'error_sites' => $errorSites,
            'total_backups' => $totalBackups,
            'sites_without_ssl' => $sitesWithoutSsl,
            'next_expiring_certificates' => $nextExpiringCertificates,
        ]);
    }
}


