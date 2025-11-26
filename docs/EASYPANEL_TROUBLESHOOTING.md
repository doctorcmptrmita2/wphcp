# EasyPanel Deploy Troubleshooting Guide

## Common Errors and Solutions

### Error: "A facade root has not been set"

**Error Message:**
```
Fatal error: Uncaught RuntimeException: A facade root has not been set. 
in /app/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
```

**Cause:**
This error occurs when Laravel's application instance is not properly initialized. This typically happens when:
1. `.env` file is missing or misconfigured
2. `APP_KEY` is not set
3. Cache files are corrupted
4. Storage directories are not writable
5. Composer dependencies are not installed

**Solutions:**

#### 1. Check Environment Configuration

Ensure `.env` file exists and contains all required variables:

**Option A: Using EasyPanel Terminal/SSH**

```bash
# Connect to EasyPanel container terminal
# Navigate to application directory (usually /app)
cd /app

# Check if .env exists
ls -la .env

# If missing, copy from .env.example
cp .env.example .env

# Or create from scratch
touch .env
```

**Option B: Using EasyPanel File Manager**

1. Open EasyPanel dashboard
2. Navigate to your service
3. Open File Manager
4. Check if `.env` file exists in root directory
5. If missing, create it or copy from `.env.example`

**Option C: Using Docker Exec (if accessible)**

```bash
# Find container name/ID
docker ps

# Execute command in container
docker exec -it <container_name> ls -la /app/.env
docker exec -it <container_name> cp /app/.env.example /app/.env
```

#### 2. Generate Application Key

```bash
# Inside EasyPanel container
php artisan key:generate
```

Or manually set in `.env`:
```env
APP_KEY=base64:your_generated_key_here
```

#### 3. Clear All Caches

```bash
# Clear configuration cache
php artisan config:clear

# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear all caches at once
php artisan optimize:clear
```

#### 4. Check Storage Permissions

```bash
# Set proper permissions for storage directories
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Or if using different user
chown -R $(whoami):$(whoami) storage bootstrap/cache
```

#### 5. Reinstall Composer Dependencies

```bash
# Remove vendor directory
rm -rf vendor

# Reinstall dependencies
composer install --no-dev --optimize-autoloader
```

#### 6. Rebuild Bootstrap Cache

```bash
# Remove bootstrap cache
rm -rf bootstrap/cache/*.php

# Regenerate bootstrap cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 7. Check Database Connection

**⚠️ IMPORTANT: WPHCP REQUIRES MYSQL - DO NOT USE SQLITE**

Ensure database configuration in `.env` is correct and uses **MySQL**:

```env
DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

**Common Error:**
```
Database file at path [/app/database/database.sqlite] does not exist
```

**Solution:**
1. Set `DB_CONNECTION=mysql` in `.env` (NOT sqlite)
2. Configure MySQL connection details
3. Ensure MySQL service is running in EasyPanel
4. Test connection:
```bash
php artisan migrate:status
```

**Why MySQL is Required:**
- WPHCP creates separate databases for each WordPress site
- Database management features require MySQL
- SQLite does not support multiple databases per application

#### 8. Verify Application Bootstrap

Check if `bootstrap/app.php` is accessible and correct:

```bash
# Check file exists
ls -la bootstrap/app.php

# Verify file permissions
chmod 644 bootstrap/app.php
```

### Error: "No application encryption key has been specified"

**Solution:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Cause:** Database connection issue

**Solution:**
1. Check database host in `.env`
2. Verify database service is running in EasyPanel
3. Check network connectivity between services
4. Verify database credentials

### Error: "The stream or file could not be opened"

**Cause:** Storage directory permissions

**Solution:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error: "Class 'X' not found"

**Cause:** Composer autoload issue

**Solution:**
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: "Required package 'laravel/sanctum' is not present in the lock file"

**Error Message:**
```
Required package "laravel/sanctum" is not present in the lock file.
This usually happens when composer files are incorrectly merged or the composer.json file is manually edited.
```

**Cause:**
`composer.json` was manually edited (Sanctum moved from `require-dev` to `require`) but `composer.lock` was not updated.

**Solution:**

```bash
# Update composer.lock file
composer require laravel/sanctum:^4.2

# Or update all dependencies
composer update

# Then commit both files
git add composer.json composer.lock
git commit -m "Move sanctum to require and update lock file"
```

**Prevention:**
Always use `composer require` or `composer update` commands instead of manually editing `composer.json`.

### Error: "Class 'Laravel\Sanctum\Sanctum' not found"

**Error Message:**
```
Class "Laravel\Sanctum\Sanctum" not found in sanctum.php line 21
```

**Cause:**
Laravel Sanctum package is not installed or is in `require-dev` but production deployment uses `--no-dev` flag.

**Solutions:**

#### Solution 1: Install Sanctum (Recommended)

```bash
# Install Sanctum package
composer require laravel/sanctum

# Clear caches
php artisan optimize:clear
```

#### Solution 2: Check composer.json

Ensure `laravel/sanctum` is in `require` section, not `require-dev`:

```json
"require": {
    "laravel/sanctum": "^4.2"
}
```

Then run:
```bash
composer update laravel/sanctum
php artisan optimize:clear
```

#### Solution 3: Reinstall Dependencies

If using `--no-dev` in production, ensure Sanctum is in `require`:

```bash
# Remove vendor directory
rm -rf vendor

# Reinstall with production dependencies
composer install --optimize-autoloader --no-dev

# Or install all dependencies (including dev)
composer install --optimize-autoloader
```

#### Solution 4: Verify Installation

```bash
# Check if Sanctum is installed
composer show laravel/sanctum

# If not found, install it
composer require laravel/sanctum
```

## EasyPanel-Specific Issues

### Container Environment Variables

Ensure all required environment variables are set in EasyPanel:

1. Go to EasyPanel service settings
2. Add environment variables:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:...
   DB_HOST=mysql
   DB_DATABASE=wphcp
   DB_USERNAME=wphcp_user
   DB_PASSWORD=secure_password
   ```

### Public Directory Configuration

If using `/public` subdirectory in URL:

1. Update `public/index.php` to handle subdirectory:
```php
// Add before require bootstrap/app.php
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
if (strpos($requestUri, '/public') === 0) {
    $_SERVER['REQUEST_URI'] = substr($requestUri, 7) ?: '/';
}
```

2. Or configure web server to point to `/app/public` directory

### Database Migration Issues

If migrations fail:

```bash
# Check migration status
php artisan migrate:status

# Run migrations
php artisan migrate --force

# If tables exist, refresh
php artisan migrate:fresh --seed
```

### Cache Driver Issues

If using database cache:

```bash
# Create cache table
php artisan cache:table
php artisan migrate

# Or switch to file cache in .env
CACHE_STORE=file
```

## Step-by-Step Deployment Checklist

### Pre-Deployment

- [ ] `.env` file is configured
- [ ] `APP_KEY` is generated
- [ ] Database connection is tested
- [ ] Composer dependencies are installed
- [ ] Storage directories are writable
- [ ] All migrations are run

### Post-Deployment

- [ ] Clear all caches
- [ ] Verify file permissions
- [ ] Test database connection
- [ ] Check application logs
- [ ] Verify environment variables
- [ ] Test application routes

## Quick Fix Script

Create a script to fix common issues:

```bash
#!/bin/bash
# fix-laravel.sh

echo "Fixing Laravel deployment issues..."

# Clear caches
php artisan optimize:clear

# Set permissions
chmod -R 775 storage bootstrap/cache

# Regenerate key if missing
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate
fi

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Dump autoload
composer dump-autoload --optimize

echo "Done!"
```

## Logs Location

Check application logs for detailed error information:

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# PHP error log (if configured)
tail -f /var/log/php/error.log

# EasyPanel container logs
# Check in EasyPanel dashboard
```

## Common Configuration Issues

### 1. APP_URL Configuration

Ensure `APP_URL` matches your EasyPanel domain:

```env
APP_URL=https://wphcp-wpcpx.lc58dd.easypanel.host
```

### 2. Session Configuration

For containerized deployments:

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### 3. Queue Configuration

If using queues:

```env
QUEUE_CONNECTION=database
```

### 4. Mail Configuration

Configure mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Testing Deployment

After fixing issues, test the deployment:

1. **Health Check:**
   ```bash
   curl https://your-domain/up
   ```

2. **Homepage:**
   ```bash
   curl https://your-domain/
   ```

3. **Check Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Getting Help

If issues persist:

1. Check EasyPanel container logs
2. Review Laravel logs: `storage/logs/laravel.log`
3. Verify all environment variables
4. Check file permissions
5. Ensure all dependencies are installed
6. Contact support with error logs

## Prevention

To prevent these issues in future deployments:

1. Always include `.env.example` in repository
2. Document all required environment variables
3. Use deployment scripts
4. Set up proper file permissions
5. Test deployment in staging first
6. Keep dependencies up to date

