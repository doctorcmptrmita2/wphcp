# EasyPanel Quick Fix Guide

## Current Issues from Logs

1. ❌ **Nginx root path is `/app` instead of `/app/public`** → **403 Forbidden**
2. ❌ **APP_KEY is not set** → **500 Internal Server Error**
3. ❌ **Database connection not configured** → **500 Internal Server Error**
4. ⚠️ Many optional environment variables missing (warnings only - **HARMLESS**)

> **Note:** Config files have been updated to reduce warnings. Most warnings are now suppressed.

## Step-by-Step Fix

### Step 1: Fix Nginx Root Path

**In EasyPanel Dashboard:**

1. Go to your service (wpcpx)
2. Look for **"Root Directory"**, **"Web Root"**, or **"Document Root"** setting
3. Change from `/app` to `/app/public`
4. Save and redeploy

**If setting doesn't exist:**

Check if there's a custom nginx config option or environment variable:
- Look for `NGINX_ROOT` or similar
- Check "Advanced Settings" or "Build Settings"

### Step 2: Set Required Environment Variables

**In EasyPanel Environment Variables section, add:**

```env
# Application (REQUIRED)
APP_NAME=WPHCP
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://wphcp-wpcpx.lc58dd.easypanel.host

# Database (REQUIRED - MYSQL)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=wphcp
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Cache & Session
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### Step 3: Generate APP_KEY

**Option A: In EasyPanel Container Terminal**

```bash
php artisan key:generate --show
# Copy the output and set as APP_KEY in EasyPanel
```

**Option B: Generate Manually**

```bash
openssl rand -base64 32
# Use output as: APP_KEY=base64:generated_key
```

### Step 4: Verify MySQL Service

1. **Check MySQL service exists in EasyPanel**
2. **Note the service name** (usually `mysql` or `db`)
3. **Set `DB_HOST` to match service name**
4. **Create database if needed:**

```bash
# In MySQL container
mysql -u root -p
CREATE DATABASE wphcp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 5: Redeploy

After making changes:
1. Save all settings
2. Redeploy service
3. Check logs for errors

## Verification

After redeploy, test:

```bash
# Should return 200, not 403
curl -I https://wphcp-wpcpx.lc58dd.easypanel.host/

# Should not show directory listing error
# Should show Laravel welcome page or login
```

## Common Mistakes

❌ **Setting root to `/app`** → Should be `/app/public`
❌ **Using SQLite** → Must use MySQL
❌ **Missing APP_KEY** → Generate and set it
❌ **Wrong DB_HOST** → Must match MySQL service name in EasyPanel

## Still Getting 403?

If root path setting doesn't exist in EasyPanel:

1. **Check Nixpacks configuration** - May need `nixpacks.toml`
2. **Check for custom nginx config** - May need `.nginx.conf`
3. **Contact EasyPanel support** - Ask how to set nginx root path

## Still Getting 500?

After fixing 403, if you get 500:

1. **Check APP_KEY is set**
2. **Check database connection**
3. **Check Laravel logs:** `tail -f storage/logs/laravel.log`
4. **Run migrations:** `php artisan migrate`

