<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Site extends Model
{
    protected $fillable = [
        'domain',
        'root_path',
        'php_version',
        'status',
        'maintenance_mode',
        'db_id',
        'last_backup_at',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'last_backup_at' => 'datetime',
    ];

    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'db_id');
    }

    public function backups(): HasMany
    {
        return $this->hasMany(Backup::class);
    }

    public function sslCertificate(): HasOne
    {
        return $this->hasOne(SslCertificate::class);
    }

    public function dnsRecords(): HasMany
    {
        return $this->hasMany(DnsRecord::class);
    }
}
