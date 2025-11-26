# EasyPanel 403 Forbidden - Nginx Configuration Fix

## Quick Diagnosis Commands

Run these commands in EasyPanel container to diagnose the issue:

```bash
# 1. Check nginx configuration
cat /etc/nginx/nginx.conf | grep -A 5 "root"

# 2. Check if nginx can access public directory
ls -la /app/public/

# 3. Check nginx error log
tail -20 /var/log/nginx/error.log

# 4. Check nginx access log
tail -20 /var/log/nginx/access.log

# 5. Test nginx configuration
nginx -t

# 6. Check current nginx root setting
grep -r "root" /etc/nginx/sites-enabled/ 2>/dev/null || grep -r "root" /etc/nginx/conf.d/ 2>/dev/null
```

## Common Issues and Solutions

### Issue 1: Root Path is `/app` instead of `/app/public`

**Check:**
```bash
grep -r "root /app" /etc/nginx/
```

**Fix in EasyPanel:**
1. Go to service settings
2. Find "Root Directory" or "Web Root"
3. Change from `/app` to `/app/public`
4. Redeploy

### Issue 2: Nginx Configuration File Location

Nixpacks/EasyPanel may use different nginx config locations:

```bash
# Check all possible locations
ls -la /etc/nginx/
ls -la /etc/nginx/sites-enabled/
ls -la /etc/nginx/conf.d/
ls -la /nginx.conf
ls -la /assets/nginx.template.conf
```

### Issue 3: PHP-FPM Not Running

```bash
# Check PHP-FPM status
ps aux | grep php-fpm

# Check PHP-FPM socket
ls -la /run/php/php*-fpm.sock
ls -la /var/run/php-fpm.sock
```

### Issue 4: Directory Index Not Allowed

Nginx may be blocking directory access. Check nginx config for:

```nginx
# Should have:
index index.php index.html;

# Should NOT have:
autoindex off;  # or missing index directive
```

## Manual Nginx Config Fix

If you can access nginx config, update it:

```nginx
server {
    listen 80;
    server_name _;
    
    # CRITICAL: Must point to public directory
    root /app/public;
    index index.php index.html index.htm;
    
    # Allow directory listing for debugging (remove in production)
    # autoindex on;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;  # Or unix:/run/php/php-fpm.sock
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\. {
        deny all;
    }
}
```

## EasyPanel Specific Fix

### Option 1: Environment Variable

Some EasyPanel setups use environment variables:

```bash
# Check for nginx root env var
env | grep -i nginx
env | grep -i root
env | grep -i public
```

### Option 2: Build Hook

Add to EasyPanel build settings:

```bash
# In build command or post-build hook
echo "root /app/public;" > /tmp/nginx_root_fix.conf
```

### Option 3: Custom Nginx Config

If EasyPanel allows custom nginx config:

1. Create `.nginx.conf` in project root
2. Set root to `/app/public`
3. EasyPanel should use it during build

## Verification Steps

After applying fixes:

```bash
# 1. Reload nginx
nginx -s reload
# Or
killall -HUP nginx

# 2. Test configuration
nginx -t

# 3. Check if index.php is accessible
curl -I http://localhost/
curl -I http://localhost/index.php

# 4. Check nginx is serving from correct directory
curl http://localhost/ | head -20
```

## Still Getting 403?

1. **Check SELinux** (if enabled):
   ```bash
   getenforce
   # If enforcing, may need to set context
   ```

2. **Check AppArmor** (if enabled):
   ```bash
   aa-status
   ```

3. **Check file ownership recursively**:
   ```bash
   find /app/public -type f -exec ls -la {} \;
   ```

4. **Check parent directory permissions**:
   ```bash
   ls -la /app/
   chmod 755 /app
   chmod 755 /app/public
   ```

5. **Test with simple HTML file**:
   ```bash
   echo "test" > /app/public/test.html
   curl http://localhost/test.html
   ```

## Contact Support

If issue persists, provide:
- Nginx error log: `tail -50 /var/log/nginx/error.log`
- Nginx config: `cat /etc/nginx/nginx.conf` or relevant config file
- Directory listing: `ls -la /app/public/`
- Nginx test: `nginx -t`

