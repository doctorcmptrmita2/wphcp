<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use App\Models\Site;
use App\Models\SslCertificate;
use Illuminate\Support\Facades\Log;

class SslService
{
    public function __construct(
        private readonly ShellService $shellService
    ) {
    }

    public function requestCertificate(Site $site): SslCertificate
    {
        $certbotBin = config('wphcp.certbot_bin');
        $letsencryptEmail = config('wphcp.letsencrypt_email');
        $webRoot = $site->root_path;

        Log::info('Requesting SSL certificate', [
            'site_id' => $site->id,
            'domain' => $site->domain,
        ]);

        try {
            // Create or update SSL certificate record with status 'requested'
            $sslCert = SslCertificate::updateOrCreate(
                ['site_id' => $site->id],
                [
                    'provider' => 'letsencrypt',
                    'domain' => $site->domain,
                    'status' => 'requested',
                ]
            );

            // Run certbot
            $result = $this->shellService->run($certbotBin, [
                'certonly',
                '--webroot',
                '--webroot-path=' . $webRoot,
                '--email=' . $letsencryptEmail,
                '--agree-tos',
                '--no-eff-email',
                '--non-interactive',
                '--domains=' . $site->domain,
            ]);

            if ($result->isSuccessful()) {
                // Parse expiration date from certbot output or use certbot certificates command
                $expiresAt = $this->getCertificateExpirationDate($site->domain);

                $sslCert->update([
                    'status' => 'active',
                    'expires_at' => $expiresAt,
                    'last_renewed_at' => now(),
                ]);

                Log::info('SSL certificate requested successfully', [
                    'ssl_certificate_id' => $sslCert->id,
                    'expires_at' => $expiresAt,
                ]);
            } else {
                $sslCert->update(['status' => 'error']);

                Log::error('SSL certificate request failed', [
                    'ssl_certificate_id' => $sslCert->id,
                    'stderr' => $result->stderr,
                ]);

                throw new \RuntimeException('SSL certificate request failed: ' . $result->stderr);
            }

            return $sslCert;
        } catch (\Exception $e) {
            Log::error('SSL certificate request error', [
                'site_id' => $site->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function renewCertificate(Site $site): SslCertificate
    {
        $certbotBin = config('wphcp.certbot_bin');

        Log::info('Renewing SSL certificate', [
            'site_id' => $site->id,
            'domain' => $site->domain,
        ]);

        try {
            $sslCert = $site->sslCertificate;

            if (! $sslCert) {
                throw new \RuntimeException('No SSL certificate found for this site');
            }

            // Run certbot renew for specific domain
            $result = $this->shellService->run($certbotBin, [
                'renew',
                '--cert-name=' . $site->domain,
                '--non-interactive',
            ]);

            if ($result->isSuccessful()) {
                $expiresAt = $this->getCertificateExpirationDate($site->domain);

                $sslCert->update([
                    'status' => 'active',
                    'expires_at' => $expiresAt,
                    'last_renewed_at' => now(),
                ]);

                Log::info('SSL certificate renewed successfully', [
                    'ssl_certificate_id' => $sslCert->id,
                    'expires_at' => $expiresAt,
                ]);
            } else {
                $sslCert->update(['status' => 'error']);

                Log::error('SSL certificate renewal failed', [
                    'ssl_certificate_id' => $sslCert->id,
                    'stderr' => $result->stderr,
                ]);

                throw new \RuntimeException('SSL certificate renewal failed: ' . $result->stderr);
            }

            return $sslCert;
        } catch (\Exception $e) {
            Log::error('SSL certificate renewal error', [
                'site_id' => $site->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function getCertificateExpirationDate(string $domain): ?\DateTime
    {
        try {
            $certbotBin = config('wphcp.certbot_bin');
            $result = $this->shellService->run($certbotBin, [
                'certificates',
                '--cert-name=' . $domain,
            ]);

            // Parse expiration date from output
            // Certbot output format: "Expiry Date: YYYY-MM-DD HH:MM:SS+00:00"
            if (preg_match('/Expiry Date: (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $result->stdout, $matches)) {
                return new \DateTime($matches[1]);
            }
        } catch (\Exception $e) {
            Log::warning('Could not parse certificate expiration date', [
                'domain' => $domain,
                'error' => $e->getMessage(),
            ]);
        }

        // Default to 90 days from now if we can't parse
        return now()->addDays(90);
    }
}

