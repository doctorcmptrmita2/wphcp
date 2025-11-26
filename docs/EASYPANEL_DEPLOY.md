# EasyPanel Deploy Configuration Guide

## Overview

WPHCP integrates with EasyPanel to enable automated deployment of WordPress sites using Docker containers. This guide explains how to configure and use EasyPanel deployment features.

## Prerequisites

1. EasyPanel must be installed and running on your server
2. EasyPanel API must be accessible
3. API token must be configured in WPHCP

## Configuration

### Environment Variables

Add the following variables to your `.env` file:

```env
# EasyPanel Configuration
EASYPANEL_ENABLED=true
EASYPANEL_API_URL=http://localhost:3000
EASYPANEL_API_TOKEN=your_api_token_here
```

### Configuration File

Settings are stored in `config/wphcp.php`:

```php
'easypanel' => [
    'api_url' => env('EASYPANEL_API_URL', 'http://localhost:3000'),
    'api_token' => env('EASYPANEL_API_TOKEN', ''),
    'enabled' => env('EASYPANEL_ENABLED', false),
],
```

## Site Settings

Each site can have individual EasyPanel deployment settings configured through the Settings page (`/sites/{id}/settings`).

### Available Settings

#### 1. Enable EasyPanel Deployment
- **Field**: `easypanel_enabled`
- **Type**: Boolean (checkbox)
- **Description**: Enable or disable EasyPanel deployment for this specific site

#### 2. Project Name
- **Field**: `easypanel_project_name`
- **Type**: String (max 255 characters)
- **Description**: The name of the project in EasyPanel
- **Example**: `my-wordpress-project`
- **Required**: Yes (when EasyPanel is enabled)

#### 3. Service Name
- **Field**: `easypanel_service_name`
- **Type**: String (max 255 characters)
- **Description**: The name of the service within the project
- **Example**: `wordpress-app`
- **Required**: Yes (when EasyPanel is enabled)

#### 4. Deploy Method
- **Field**: `easypanel_deploy_method`
- **Type**: Enum
- **Options**:
  - `git` - Deploy from Git repository
  - `docker_image` - Deploy from Docker image
  - `docker_compose` - Deploy using Docker Compose
- **Description**: Choose how the service will be deployed
- **Required**: Yes (when EasyPanel is enabled)

#### 5. Repository URL (Git Method)
- **Field**: `easypanel_repository_url`
- **Type**: URL
- **Description**: Git repository URL for deployment
- **Example**: `https://github.com/user/wordpress-site.git`
- **Required**: Yes (when deploy method is `git`)

#### 6. Branch (Git Method)
- **Field**: `easypanel_branch`
- **Type**: String (max 255 characters)
- **Default**: `main`
- **Description**: Git branch to deploy from
- **Example**: `main`, `develop`, `production`
- **Required**: Yes (when deploy method is `git`)

#### 7. Docker Image (Docker Image Method)
- **Field**: `easypanel_docker_image`
- **Type**: String (max 255 characters)
- **Description**: Docker image name and tag
- **Example**: `wordpress:latest`, `wordpress:6.3-php8.2-apache`
- **Required**: Yes (when deploy method is `docker_image`)

#### 8. Port
- **Field**: `easypanel_port`
- **Type**: Integer (1-65535)
- **Description**: Port number for the service
- **Example**: `3000`, `8080`, `80`
- **Required**: No (but recommended)

#### 9. CPU Limit
- **Field**: `easypanel_cpu_limit`
- **Type**: String (max 50 characters)
- **Description**: CPU resource limit
- **Example**: `0.5`, `1`, `2`, `1.5`
- **Format**: Number (can include decimals)
- **Required**: No

#### 10. Memory Limit
- **Field**: `easypanel_memory_limit`
- **Type**: String (max 50 characters)
- **Description**: Memory resource limit
- **Example**: `512M`, `1G`, `2G`, `1024M`
- **Format**: Number followed by unit (M for MB, G for GB)
- **Required**: No

#### 11. Environment Variables
- **Field**: `easypanel_env_vars`
- **Type**: JSON Array (Key-Value pairs)
- **Description**: Environment variables to pass to the container
- **Example**:
  ```json
  {
    "WORDPRESS_DB_HOST": "mysql:3306",
    "WORDPRESS_DB_NAME": "wordpress",
    "WORDPRESS_DB_USER": "wp_user",
    "WORDPRESS_DB_PASSWORD": "secure_password"
  }
  ```
- **Required**: No

## Database Schema

The following fields are added to the `sites` table:

```php
$table->boolean('easypanel_enabled')->default(false);
$table->string('easypanel_project_name')->nullable();
$table->string('easypanel_service_name')->nullable();
$table->enum('easypanel_deploy_method', ['git', 'docker_image', 'docker_compose'])->nullable();
$table->string('easypanel_repository_url')->nullable();
$table->string('easypanel_branch')->default('main');
$table->string('easypanel_docker_image')->nullable();
$table->integer('easypanel_port')->nullable();
$table->json('easypanel_env_vars')->nullable();
$table->string('easypanel_cpu_limit')->nullable();
$table->string('easypanel_memory_limit')->nullable();
```

## Usage

### Step 1: Enable EasyPanel Globally

1. Edit your `.env` file
2. Set `EASYPANEL_ENABLED=true`
3. Configure `EASYPANEL_API_URL` and `EASYPANEL_API_TOKEN`
4. Restart your Laravel application

### Step 2: Configure Site Settings

1. Navigate to Site Settings: `/sites/{id}/settings`
2. Scroll to "EasyPanel Deploy" section
3. Check "Enable EasyPanel Deployment"
4. Fill in the required fields:
   - **Project Name**: Your EasyPanel project name
   - **Service Name**: Service name within the project
   - **Deploy Method**: Choose your deployment method

### Step 3: Configure Deploy Method

#### For Git Deployment:
1. Select "Git Repository" as deploy method
2. Enter repository URL
3. Specify branch name (default: `main`)

#### For Docker Image Deployment:
1. Select "Docker Image" as deploy method
2. Enter Docker image name (e.g., `wordpress:latest`)

#### For Docker Compose Deployment:
1. Select "Docker Compose" as deploy method
2. Configure additional settings as needed

### Step 4: Set Resource Limits (Optional)

- **Port**: Container port number
- **CPU Limit**: CPU allocation (e.g., `0.5`, `1`, `2`)
- **Memory Limit**: Memory allocation (e.g., `512M`, `1G`)

### Step 5: Add Environment Variables (Optional)

1. Click "Add Environment Variable"
2. Enter key-value pairs
3. Add multiple variables as needed
4. Remove variables using the X button

### Step 6: Save Settings

Click "Save EasyPanel Settings" to apply the configuration.

## Example Configurations

### Example 1: WordPress with Git Deployment

```yaml
Project Name: wordpress-sites
Service Name: my-blog
Deploy Method: git
Repository URL: https://github.com/user/wordpress-blog.git
Branch: main
Port: 80
CPU Limit: 1
Memory Limit: 1G
Environment Variables:
  - WORDPRESS_DB_HOST: mysql:3306
  - WORDPRESS_DB_NAME: wordpress_db
  - WORDPRESS_DB_USER: wp_user
  - WORDPRESS_DB_PASSWORD: secure_pass
```

### Example 2: WordPress with Docker Image

```yaml
Project Name: wordpress-sites
Service Name: quick-start
Deploy Method: docker_image
Docker Image: wordpress:6.3-php8.2-apache
Port: 8080
CPU Limit: 0.5
Memory Limit: 512M
Environment Variables:
  - WORDPRESS_DB_HOST: db
  - WORDPRESS_DB_NAME: wp_db
```

### Example 3: Custom Application with Docker Compose

```yaml
Project Name: custom-apps
Service Name: my-app
Deploy Method: docker_compose
Port: 3000
CPU Limit: 2
Memory Limit: 2G
Environment Variables:
  - NODE_ENV: production
  - API_KEY: your_api_key
```

## API Integration

The EasyPanel settings are stored in the database and can be accessed via:

- **Web Interface**: `/sites/{id}/settings`
- **API Endpoint**: `/api/v1/sites/{id}` (returns site data including EasyPanel settings)

## Troubleshooting

> **For detailed troubleshooting guide, see [EASYPANEL_TROUBLESHOOTING.md](./EASYPANEL_TROUBLESHOOTING.md)**

### Common Errors

#### "A facade root has not been set"

This error indicates Laravel bootstrap failed. Quick fixes:

```bash
# 1. Generate application key
php artisan key:generate

# 2. Clear all caches
php artisan optimize:clear

# 3. Set storage permissions
chmod -R 775 storage bootstrap/cache

# 4. Rebuild caches
php artisan config:cache
php artisan route:cache
```

See [EASYPANEL_TROUBLESHOOTING.md](./EASYPANEL_TROUBLESHOOTING.md) for detailed solutions.

### EasyPanel Section Not Visible

- Check if `EASYPANEL_ENABLED=true` in `.env`
- Verify `config/wphcp.php` has EasyPanel configuration
- Clear config cache: `php artisan config:clear`

### Settings Not Saving

- Check database migration: `php artisan migrate`
- Verify form validation errors
- Check Laravel logs: `storage/logs/laravel.log`

### Deployment Issues

- Verify EasyPanel API URL is accessible
- Check API token is valid
- Ensure project and service names are correct
- Review EasyPanel logs for deployment errors

## Best Practices

1. **Naming Convention**: Use consistent naming for projects and services
2. **Resource Limits**: Set appropriate CPU and memory limits based on site requirements
3. **Environment Variables**: Store sensitive data in environment variables, not in code
4. **Branch Strategy**: Use different branches for staging and production
5. **Port Management**: Avoid port conflicts by using unique ports per service
6. **Backup**: Always backup your configuration before making changes

## Security Considerations

1. **API Token**: Keep your EasyPanel API token secure
2. **Environment Variables**: Never commit sensitive environment variables to version control
3. **Access Control**: Restrict access to site settings page
4. **Validation**: All inputs are validated before saving

## Related Documentation

- [EasyPanel Official Documentation](https://easypanel.io/docs)
- [Docker Documentation](https://docs.docker.com/)
- [WordPress Docker Images](https://hub.docker.com/_/wordpress)

## Support

For issues or questions:
- Check WPHCP logs: `storage/logs/laravel.log`
- Review EasyPanel logs
- Contact support: support@wphcp.io

