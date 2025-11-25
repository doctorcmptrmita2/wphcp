<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use App\Models\DnsRecord;
use App\Models\Site;
use Illuminate\Support\Facades\Log;

class DnsService
{
    public function createDefaultRecords(Site $site): void
    {
        $defaultIp = config('wphcp.default_server_ip', '127.0.0.1');

        $defaultRecords = [
            [
                'type' => 'A',
                'name' => '@',
                'value' => $defaultIp,
                'ttl' => 3600,
                'notes' => 'Root domain A record',
            ],
            [
                'type' => 'A',
                'name' => 'www',
                'value' => $defaultIp,
                'ttl' => 3600,
                'notes' => 'WWW subdomain A record',
            ],
        ];

        foreach ($defaultRecords as $record) {
            DnsRecord::create([
                'site_id' => $site->id,
                'type' => $record['type'],
                'name' => $record['name'],
                'value' => $record['value'],
                'ttl' => $record['ttl'],
                'notes' => $record['notes'],
                'active' => true,
            ]);
        }

        Log::info('Default DNS records created', ['site_id' => $site->id]);
    }

    public function createRecord(Site $site, array $data): DnsRecord
    {
        return DnsRecord::create([
            'site_id' => $site->id,
            'type' => $data['type'],
            'name' => $data['name'],
            'value' => $data['value'],
            'ttl' => $data['ttl'] ?? 3600,
            'priority' => $data['priority'] ?? null,
            'active' => $data['active'] ?? true,
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function updateRecord(DnsRecord $record, array $data): void
    {
        $record->update($data);
    }

    public function deleteRecord(DnsRecord $record): void
    {
        $record->delete();
    }
}

