<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use App\Models\Backup;
use App\Models\Database;
use App\Models\Site;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupService
{
    public function __construct(
        private readonly ShellService $shellService
    ) {
    }

    public function createBackup(Site $site, string $type = 'manual'): Backup
    {
        $backupsPath = config('wphcp.backups_path');
        $timestamp = now()->format('Y-m-d_H-i-s');
        $backupFilename = $site->domain . '-' . $timestamp . '.tar.gz';
        $backupPath = $backupsPath . '/' . $backupFilename;

        Log::info('Starting backup creation', [
            'site_id' => $site->id,
            'domain' => $site->domain,
            'type' => $type,
        ]);

        try {
            // Ensure backups directory exists
            if (!File::exists($backupsPath)) {
                File::makeDirectory($backupsPath, 0755, true);
            }

            // Create temporary directory for backup
            $tempDir = sys_get_temp_dir() . '/wphcp_backup_' . $site->id . '_' . $timestamp;
            File::makeDirectory($tempDir, 0755, true);

            // Backup database
            if ($site->database) {
                $this->backupDatabase($site->database, $tempDir);
            }

            // Backup files
            if (File::exists($site->root_path)) {
                $this->backupFiles($site->root_path, $tempDir);
            }

            // Create tar.gz archive
            $this->createArchive($tempDir, $backupPath);

            // Cleanup temp directory
            File::deleteDirectory($tempDir);

            // Calculate size
            $sizeMb = File::exists($backupPath) ? round(File::size($backupPath) / 1024 / 1024, 2) : null;

            // Create backup record
            $backup = Backup::create([
                'site_id' => $site->id,
                'type' => $type,
                'status' => 'success',
                'disk' => 'local',
                'path' => $backupPath,
                'size_mb' => $sizeMb,
            ]);

            // Update site's last_backup_at
            $site->update(['last_backup_at' => now()]);

            Log::info('Backup created successfully', [
                'backup_id' => $backup->id,
                'size_mb' => $sizeMb,
            ]);

            return $backup;
        } catch (\Exception $e) {
            Log::error('Backup creation failed', [
                'site_id' => $site->id,
                'error' => $e->getMessage(),
            ]);

            // Create failed backup record
            $backup = Backup::create([
                'site_id' => $site->id,
                'type' => $type,
                'status' => 'failed',
                'disk' => 'local',
                'path' => $backupPath ?? null,
            ]);

            throw $e;
        }
    }

    public function restoreBackup(Backup $backup): void
    {
        // TODO: Implement restore functionality
        // This is a placeholder for future implementation
        Log::info('Restore backup requested', [
            'backup_id' => $backup->id,
            'site_id' => $backup->site_id,
        ]);

        throw new \RuntimeException('Backup restore is not yet implemented');
    }

    private function backupDatabase(Database $database, string $tempDir): void
    {
        $dumpFile = $tempDir . '/database.sql';
        $dbHost = $database->host;
        $dbPort = $database->port;
        $password = $database->decrypted_password;

        // Use environment variable for password to avoid shell injection
        $command = sprintf(
            'MYSQL_PWD=%s mysqldump -h %s -P %d -u %s %s > %s',
            escapeshellarg($password),
            escapeshellarg($dbHost),
            escapeshellarg((string) $dbPort),
            escapeshellarg($database->username),
            escapeshellarg($database->name),
            escapeshellarg($dumpFile)
        );

        $this->shellService->run('bash', ['-c', $command]);

        Log::info('Database backup completed', [
            'database_id' => $database->id,
            'dump_file' => $dumpFile,
        ]);
    }

    private function backupFiles(string $sourcePath, string $tempDir): void
    {
        $filesDir = $tempDir . '/files';
        File::makeDirectory($filesDir, 0755, true);

        $this->shellService->run('cp', ['-r', $sourcePath, $filesDir . '/wordpress']);

        Log::info('Files backup completed', ['source_path' => $sourcePath]);
    }

    private function createArchive(string $sourceDir, string $targetPath): void
    {
        $this->shellService->run('tar', [
            '-czf',
            $targetPath,
            '-C',
            dirname($sourceDir),
            basename($sourceDir),
        ]);

        Log::info('Archive created', ['path' => $targetPath]);
    }
}

