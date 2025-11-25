<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Crypt;

class Database extends Model
{
    protected $fillable = [
        'name',
        'username',
        'password_encrypted',
        'host',
        'port',
        'status',
        'size_mb',
    ];

    protected $casts = [
        'port' => 'integer',
        'size_mb' => 'decimal:2',
    ];

    public function site(): HasOne
    {
        return $this->hasOne(Site::class, 'db_id');
    }

    public function getDecryptedPasswordAttribute(): string
    {
        return Crypt::decryptString($this->password_encrypted);
    }
}
