<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Backup;
use App\Models\Database;
use App\Models\Site;
use App\Models\SslCertificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DemoWphcpSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo databases
        $database1 = Database::firstOrCreate(
            ['name' => 'wp_example_com'],
            [
                'username' => 'wp_example_com',
                'password_encrypted' => Crypt::encryptString('demo_password_123'),
                'host' => '127.0.0.1',
                'port' => 3306,
                'status' => 'active',
                'size_mb' => 15.50,
            ]
        );

        $database2 = Database::firstOrCreate(
            ['name' => 'wp_demo_site'],
            [
                'username' => 'wp_demo_site',
                'password_encrypted' => Crypt::encryptString('demo_password_456'),
                'host' => '127.0.0.1',
                'port' => 3306,
                'status' => 'active',
                'size_mb' => 8.25,
            ]
        );

        // Create demo sites
        $site1 = Site::firstOrCreate(
            ['domain' => 'example.com'],
            [
                'root_path' => '/var/www/example.com',
                'php_version' => '8.2',
                'status' => 'active',
                'maintenance_mode' => false,
                'db_id' => $database1->id,
                'last_backup_at' => now()->subDays(2),
            ]
        );

        $site2 = Site::firstOrCreate(
            ['domain' => 'demo-site.com'],
            [
                'root_path' => '/var/www/demo-site.com',
                'php_version' => '8.1',
                'status' => 'active',
                'maintenance_mode' => false,
                'db_id' => $database2->id,
                'last_backup_at' => now()->subDays(5),
            ]
        );

        $site3 = Site::firstOrCreate(
            ['domain' => 'test-site.com'],
            [
                'root_path' => '/var/www/test-site.com',
                'php_version' => '8.2',
                'status' => 'creating',
                'maintenance_mode' => false,
            ]
        );

        // Create demo backups
        Backup::create([
            'site_id' => $site1->id,
            'type' => 'manual',
            'status' => 'success',
            'disk' => 'local',
            'path' => '/var/backups/wphcp/example.com-2025-11-23.tar.gz',
            'size_mb' => 125.50,
        ]);

        Backup::create([
            'site_id' => $site1->id,
            'type' => 'auto',
            'status' => 'success',
            'disk' => 'local',
            'path' => '/var/backups/wphcp/example.com-2025-11-25.tar.gz',
            'size_mb' => 130.25,
        ]);

        Backup::create([
            'site_id' => $site2->id,
            'type' => 'manual',
            'status' => 'success',
            'disk' => 'local',
            'path' => '/var/backups/wphcp/demo-site.com-2025-11-20.tar.gz',
            'size_mb' => 45.75,
        ]);

        Backup::create([
            'site_id' => $site2->id,
            'type' => 'auto',
            'status' => 'failed',
            'disk' => 'local',
            'path' => '/var/backups/wphcp/demo-site.com-failed-backup.tar.gz',
        ]);

        // Create demo SSL certificates
        SslCertificate::create([
            'site_id' => $site1->id,
            'provider' => 'letsencrypt',
            'domain' => 'example.com',
            'status' => 'active',
            'expires_at' => now()->addDays(60),
            'last_renewed_at' => now()->subDays(30),
        ]);

        SslCertificate::create([
            'site_id' => $site2->id,
            'provider' => 'letsencrypt',
            'domain' => 'demo-site.com',
            'status' => 'active',
            'expires_at' => now()->addDays(15),
            'last_renewed_at' => now()->subDays(75),
        ]);
    }
}

