# Database Setup Guide

## ⚠️ IMPORTANT: MySQL Required

**WPHCP REQUIRES MYSQL DATABASE - SQLITE IS NOT SUPPORTED**

WPHCP is designed to work with MySQL because:
- Each WordPress site requires its own database
- Database management features require MySQL
- SQLite does not support multiple databases per application

## EasyPanel Database Configuration

### Option 1: Use EasyPanel MySQL Service

1. **Create MySQL Service in EasyPanel:**
   - Go to EasyPanel dashboard
   - Create a new MySQL service
   - Note the service name (e.g., `mysql`)

2. **Configure .env:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=wphcp
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_root_password
   ```

3. **Create Database:**
   ```bash
   # Connect to MySQL container
   docker exec -it <mysql_container> mysql -u root -p
   
   # Create database
   CREATE DATABASE wphcp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   
   # Create user (optional)
   CREATE USER 'wphcp'@'%' IDENTIFIED BY 'secure_password';
   GRANT ALL PRIVILEGES ON wphcp.* TO 'wphcp'@'%';
   FLUSH PRIVILEGES;
   ```

### Option 2: External MySQL Server

If using external MySQL server:

```env
DB_CONNECTION=mysql
DB_HOST=your_mysql_host
DB_PORT=3306
DB_DATABASE=wphcp
DB_USERNAME=wphcp_user
DB_PASSWORD=secure_password
```

### Option 3: EasyPanel Database Service

Some EasyPanel setups include a database service:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=wphcp
DB_USERNAME=wphcp
DB_PASSWORD=password_from_easypanel
```

## Environment Variables

Required database configuration in `.env`:

```env
# Database Configuration (REQUIRED - MUST BE MYSQL)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=wphcp
DB_USERNAME=root
DB_PASSWORD=your_password

# Optional
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

## Common Errors

### Error: "Database file at path [/app/database/database.sqlite] does not exist"

**Cause:** Application is trying to use SQLite instead of MySQL

**Solution:**
1. Check `.env` file has `DB_CONNECTION=mysql`
2. Clear config cache: `php artisan config:clear`
3. Verify MySQL service is running
4. Test connection: `php artisan migrate:status`

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Cause:** Cannot connect to MySQL server

**Solution:**
1. Verify MySQL service is running in EasyPanel
2. Check `DB_HOST` matches MySQL service name
3. Verify network connectivity between services
4. Check MySQL port (default: 3306)
5. Verify credentials are correct

### Error: "Access denied for user"

**Cause:** Wrong username or password

**Solution:**
1. Verify `DB_USERNAME` and `DB_PASSWORD` in `.env`
2. Check MySQL user has proper permissions
3. Ensure user can access the database

## Initial Setup

After configuring database:

```bash
# 1. Clear config cache
php artisan config:clear

# 2. Run migrations
php artisan migrate

# 3. (Optional) Seed demo data
php artisan db:seed
```

## Testing Connection

```bash
# Test database connection
php artisan migrate:status

# Or use tinker
php artisan tinker
>>> DB::connection()->getPdo();
```

## Database Requirements

- **MySQL Version:** 5.7+ or MariaDB 10.3+
- **Character Set:** utf8mb4
- **Collation:** utf8mb4_unicode_ci
- **Storage Engine:** InnoDB (default)

## Security Best Practices

1. **Use Strong Passwords:** Generate secure passwords for database users
2. **Limit Access:** Only grant necessary privileges
3. **Network Security:** Use internal network for database connections
4. **Backup Regularly:** Set up automated database backups
5. **Environment Variables:** Never commit `.env` file to version control

## Troubleshooting

### Check MySQL Service Status

```bash
# In EasyPanel, check service logs
# Or via Docker
docker ps | grep mysql
docker logs <mysql_container>
```

### Verify Network Connectivity

```bash
# From application container, test MySQL connection
docker exec -it <app_container> ping mysql
docker exec -it <app_container> telnet mysql 3306
```

### Reset Database Connection

```bash
# Clear all caches
php artisan optimize:clear

# Rebuild config cache
php artisan config:cache

# Test again
php artisan migrate:status
```

## Related Documentation

- [EasyPanel Deploy Guide](./EASYPANEL_DEPLOY.md)
- [Troubleshooting Guide](./EASYPANEL_TROUBLESHOOTING.md)

