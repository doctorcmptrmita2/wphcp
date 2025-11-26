<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use App\Data\Wphcp\SiteProvisioningData;
use App\Models\Database;
use App\Models\Site;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SiteProvisioningService
{
    public function __construct(
        private readonly ShellService $shellService
    ) {
    }

    public function provisionSite(
        SiteProvisioningData $data,
        Database $database,
        Site $site
    ): Site {
        $rootPath = config('wphcp.web_root_base') . '/' . $data->domain;
        $phpVersion = $data->phpVersion ?? config('wphcp.default_php_version');
        $wpCliBin = config('wphcp.wp_cli_bin');

        Log::info('Starting site provisioning', [
            'domain' => $data->domain,
            'root_path' => $rootPath,
        ]);

        try {
            // Create root directory
            if (!File::exists($rootPath)) {
                File::makeDirectory($rootPath, 0755, true);
                Log::info('Created root directory', ['path' => $rootPath]);
            }

            // Download WordPress core
            $this->shellService->run($wpCliBin, [
                'core',
                'download',
                '--path=' . $rootPath,
            ]);

            // Generate wp-config.php
            $this->shellService->run($wpCliBin, [
                'config',
                'create',
                '--dbname=' . $database->name,
                '--dbuser=' . $database->username,
                '--dbpass=' . $database->decrypted_password,
                '--dbhost=' . $database->host,
                '--path=' . $rootPath,
            ]);

            // Install WordPress
            $this->shellService->run($wpCliBin, [
                'core',
                'install',
                '--url=' . $data->domain,
                '--title=' . escapeshellarg($data->siteTitle),
                '--admin_user=' . $data->adminUsername,
                '--admin_email=' . $data->adminEmail,
                '--admin_password=' . escapeshellarg($data->adminPassword),
                '--path=' . $rootPath,
            ]);

            // Create Nginx vhost config
            $this->createNginxConfig($data->domain, $rootPath, $phpVersion);

            // Enable site
            $this->enableNginxSite($data->domain);

            // Reload Nginx
            $this->reloadNginx();

            // Update site record
            $site->update([
                'root_path' => $rootPath,
                'php_version' => $phpVersion,
                'status' => 'active',
                'db_id' => $database->id,
            ]);

            Log::info('Site provisioning completed successfully', [
                'site_id' => $site->id,
                'domain' => $data->domain,
            ]);

            return $site;
        } catch (\Exception $e) {
            Log::error('Site provisioning failed', [
                'site_id' => $site->id,
                'domain' => $data->domain,
                'error' => $e->getMessage(),
            ]);

            $site->update(['status' => 'error']);

            throw $e;
        }
    }

    public function toggleMaintenanceMode(Site $site, bool $enabled): void
    {
        $wpCliBin = config('wphcp.wp_cli_bin');

        try {
            if ($enabled) {
                $this->shellService->run($wpCliBin, [
                    'maintenance-mode',
                    'activate',
                    '--path=' . $site->root_path,
                ]);
            } else {
                $this->shellService->run($wpCliBin, [
                    'maintenance-mode',
                    'deactivate',
                    '--path=' . $site->root_path,
                ]);
            }

            $site->update(['maintenance_mode' => $enabled]);

            Log::info('Maintenance mode toggled', [
                'site_id' => $site->id,
                'enabled' => $enabled,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle maintenance mode', [
                'site_id' => $site->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function resetAdminPassword(Site $site, string $newPassword): void
    {
        $wpCliBin = config('wphcp.wp_cli_bin');

        try {
            $this->shellService->run($wpCliBin, [
                'user',
                'update',
                'admin',
                '--user_pass=' . escapeshellarg($newPassword),
                '--path=' . $site->root_path,
            ]);

            Log::info('Admin password reset', ['site_id' => $site->id]);
        } catch (\Exception $e) {
            Log::error('Failed to reset admin password', [
                'site_id' => $site->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function createNginxConfig(string $domain, string $rootPath, string $phpVersion): void
    {
        $sitesAvailable = config('wphcp.nginx.sites_available');
        $phpFpmSocket = config('wphcp.php_fpm_socket');
        $configPath = $sitesAvailable . '/' . $domain;

        $config = <<<NGINX
server {
    listen 80;
    server_name {$domain} www.{$domain};
    root {$rootPath};
    index index.php index.html index.htm;

    access_log /var/log/nginx/{$domain}-access.log;
    error_log /var/log/nginx/{$domain}-error.log;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass {$phpFpmSocket};
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
NGINX;

        File::put($configPath, $config);
        Log::info('Created Nginx config', ['path' => $configPath]);
    }

    private function enableNginxSite(string $domain): void
    {
        $sitesAvailable = config('wphcp.nginx.sites_available');
        $sitesEnabled = config('wphcp.nginx.sites_enabled');
        $source = $sitesAvailable . '/' . $domain;
        $target = $sitesEnabled . '/' . $domain;

        if (!File::exists($target)) {
            File::link($source, $target);
            Log::info('Enabled Nginx site', ['domain' => $domain]);
        }
    }

    private function reloadNginx(): void
    {
        $this->shellService->run('nginx', ['-t']);
        $this->shellService->run('systemctl', ['reload', 'nginx']);
    }
}


