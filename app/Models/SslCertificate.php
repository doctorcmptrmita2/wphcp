<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SslCertificate extends Model
{
    protected $fillable = [
        'site_id',
        'provider',
        'domain',
        'status',
        'expires_at',
        'last_renewed_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_renewed_at' => 'datetime',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
