<?php

declare(strict_types=1);

return [
    'web_root_base' => env('WPHCP_WEB_ROOT_BASE', '/var/www'),
    'nginx' => [
        'sites_available' => env('WPHCP_NGINX_SITES_AVAILABLE', '/etc/nginx/sites-available'),
        'sites_enabled' => env('WPHCP_NGINX_SITES_ENABLED', '/etc/nginx/sites-enabled'),
    ],
    'backups_path' => env('WPHCP_BACKUPS_PATH', '/var/backups/wphcp'),
    'php_fpm_socket' => env('WPHCP_PHP_FPM_SOCKET', 'unix:/run/php/php8.2-fpm.sock'),
    'wp_cli_bin' => env('WPHCP_WP_CLI_BIN', '/usr/local/bin/wp'),
    'certbot_bin' => env('WPHCP_CERTBOT_BIN', '/usr/bin/certbot'),
    'default_php_version' => env('WPHCP_DEFAULT_PHP_VERSION', '8.2'),
    'letsencrypt_email' => env('WPHCP_LETSENCRYPT_EMAIL', 'admin@example.com'),
    'default_server_ip' => env('WPHCP_DEFAULT_SERVER_IP', '127.0.0.1'),
    'phpmyadmin_url' => env('WPHCP_PHPMYADMIN_URL', 'http://localhost/phpmyadmin'),
    'phpmyadmin_direct_redirect' => env('WPHCP_PHPMYADMIN_DIRECT_REDIRECT', false),
    'adminer_enabled' => env('WPHCP_ADMINER_ENABLED', false),
    'adminer_path' => env('WPHCP_ADMINER_PATH', public_path('adminer.php')),
    
    'easypanel' => [
        'api_url' => env('EASYPANEL_API_URL', 'http://localhost:3000'),
        'api_token' => env('EASYPANEL_API_TOKEN', ''),
        'enabled' => env('EASYPANEL_ENABLED', false),
    ],
];

