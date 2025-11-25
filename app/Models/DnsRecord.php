<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DnsRecord extends Model
{
    protected $fillable = [
        'site_id',
        'type',
        'name',
        'value',
        'ttl',
        'priority',
        'active',
        'notes',
    ];

    protected $casts = [
        'active' => 'boolean',
        'ttl' => 'integer',
        'priority' => 'integer',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
