<?php

declare(strict_types=1);

namespace App\Data\Wphcp;

class SiteProvisioningData
{
    public function __construct(
        public readonly string $domain,
        public readonly string $siteTitle,
        public readonly string $adminUsername,
        public readonly string $adminEmail,
        public readonly string $adminPassword,
        public readonly ?string $phpVersion = null
    ) {
    }
}

