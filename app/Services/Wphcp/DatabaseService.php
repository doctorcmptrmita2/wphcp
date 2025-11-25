<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use App\Models\Database;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DatabaseService
{
    public function __construct(
        private readonly ShellService $shellService
    ) {
    }

    public function createDatabaseForDomain(string $domain): Database
    {
        $dbName = $this->normalizeDomainToDbName($domain);
        $username = $this->normalizeDomainToDbName($domain);
        $password = Str::random(32);

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', 3306);
        $rootPassword = config('database.connections.mysql.password', '');

        Log::info('Creating database for domain', ['domain' => $domain, 'db_name' => $dbName]);

        DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
        DB::statement("CREATE USER IF NOT EXISTS '{$username}'@'{$dbHost}' IDENTIFIED BY '{$password}'");
        DB::statement("GRANT ALL PRIVILEGES ON `{$dbName}`.* TO '{$username}'@'{$dbHost}'");
        DB::statement('FLUSH PRIVILEGES');

        $database = Database::create([
            'name' => $dbName,
            'username' => $username,
            'password_encrypted' => Crypt::encryptString($password),
            'host' => $dbHost,
            'port' => $dbPort,
            'status' => 'active',
        ]);

        Log::info('Database created successfully', ['database_id' => $database->id]);

        return $database;
    }

    public function estimateDatabaseSize(Database $database): void
    {
        try {
            $result = DB::selectOne(
                "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb 
                 FROM information_schema.tables 
                 WHERE table_schema = ?",
                [$database->name]
            );

            if ($result && isset($result->size_mb)) {
                $database->update(['size_mb' => $result->size_mb]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to estimate database size', [
                'database_id' => $database->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function normalizeDomainToDbName(string $domain): string
    {
        $normalized = strtolower($domain);
        $normalized = preg_replace('/[^a-z0-9]/', '_', $normalized);
        $normalized = preg_replace('/_+/', '_', $normalized);
        $normalized = trim($normalized, '_');
        $normalized = 'wp_' . $normalized;

        if (strlen($normalized) > 64) {
            $normalized = substr($normalized, 0, 64);
        }

        return $normalized;
    }
}

