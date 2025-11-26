<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\Wphcp\RenewSslJob;
use App\Models\Site;
use App\Models\SslCertificate;
use App\Services\Wphcp\SslService;
use Illuminate\Http\JsonResponse;

class SslController extends Controller
{
    public function __construct(
        private readonly SslService $sslService
    ) {
    }

    public function index(): JsonResponse
    {
        $sslCertificates = SslCertificate::with('site')
            ->get()
            ->map(function ($cert) {
                return [
                    'site_id' => $cert->site_id,
                    'domain' => $cert->domain,
                    'status' => $cert->status,
                    'expires_at' => $cert->expires_at,
                    'last_renewed_at' => $cert->last_renewed_at,
                ];
            });

        return response()->json($sslCertificates);
    }

    public function request(Site $site): JsonResponse
    {
        try {
            $sslCertificate = $this->sslService->requestCertificate($site);

            return response()->json([
                'message' => 'SSL certificate requested successfully',
                'ssl_certificate' => $sslCertificate,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to request SSL certificate',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function renew(Site $site): JsonResponse
    {
        try {
            RenewSslJob::dispatch($site->id);

            return response()->json([
                'message' => 'SSL renewal job has been queued',
                'site_id' => $site->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to queue SSL renewal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}


