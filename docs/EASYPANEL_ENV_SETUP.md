# EasyPanel Environment Variables Setup

## Required Environment Variables

For WPHCP to work properly in EasyPanel, you must set these environment variables:

### Critical (Required)

```env
# Application
APP_NAME=WPHCP
APP_ENV=production
APP_KEY=base64:YOUR_32_CHARACTER_KEY_HERE
APP_DEBUG=false
APP_URL=https://wphcp-wpcpx.lc58dd.easypanel.host

# Database (MYSQL REQUIRED - NOT SQLITE)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=wphcp
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Important

```env
# Cache
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Mail (Optional but recommended)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@wphcp.io"
MAIL_FROM_NAME="${APP_NAME}"
```

### Optional (Can be left empty)

These variables are optional and warnings can be ignored:
- `DB_CACHE_CONNECTION`
- `DB_CACHE_LOCK_CONNECTION`
- `MEMCACHED_*`
- `AWS_*`
- `REDIS_*`
- `LOG_*`
- `MAIL_*` (if not using mail)

## How to Set in EasyPanel

1. **Go to EasyPanel Dashboard**
2. **Select your service (wpcpx)**
3. **Go to "Environment Variables" or "Env" section**
4. **Add each variable** with its value
5. **Save and redeploy**

## Generate APP_KEY

```bash
# In EasyPanel container terminal
php artisan key:generate --show

# Or generate manually
openssl rand -base64 32
```

Then set in EasyPanel:
```
APP_KEY=base64:generated_key_here
```

## Quick Setup Script

Create a script to set all required variables:

```bash
#!/bin/bash
# setup-env.sh

# Generate APP_KEY
APP_KEY=$(php artisan key:generate --show | grep "base64" | cut -d' ' -f3)

echo "Add these to EasyPanel environment variables:"
echo ""
echo "APP_NAME=WPHCP"
echo "APP_ENV=production"
echo "APP_KEY=$APP_KEY"
echo "APP_DEBUG=false"
echo "APP_URL=https://your-domain.com"
echo ""
echo "DB_CONNECTION=mysql"
echo "DB_HOST=mysql"
echo "DB_PORT=3306"
echo "DB_DATABASE=wphcp"
echo "DB_USERNAME=root"
echo "DB_PASSWORD=your_password"
echo ""
echo "CACHE_STORE=database"
echo "SESSION_DRIVER=database"
echo "QUEUE_CONNECTION=database"
```

## Verification

After setting variables, verify:

```bash
# Check APP_KEY is set
php artisan tinker
>>> config('app.key')

# Test database connection
php artisan migrate:status

# Clear config cache
php artisan config:clear
php artisan config:cache
```

## Common Issues

### "Your app key is not set"

**Solution:**
```bash
php artisan key:generate
# Then add to EasyPanel: APP_KEY=base64:...
```

### "Database connection refused"

**Solution:**
- Verify MySQL service is running
- Check `DB_HOST` matches MySQL service name
- Verify credentials

### Too many warnings

**Solution:**
Most warnings are harmless. To reduce them, set optional variables to empty values or ignore them.

