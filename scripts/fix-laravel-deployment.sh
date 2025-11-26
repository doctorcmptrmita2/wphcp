#!/bin/bash

# Laravel Deployment Fix Script
# This script fixes common Laravel deployment issues in EasyPanel/Docker environments

set -e

echo "🔧 Starting Laravel deployment fix..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in Laravel root
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from Laravel root directory.${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Checking .env file...${NC}"
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}.env file not found. Creating from .env.example...${NC}"
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo -e "${GREEN}.env file created.${NC}"
    else
        echo -e "${RED}Error: .env.example not found. Please create .env manually.${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}.env file exists.${NC}"
fi

echo -e "${YELLOW}Step 2: Checking APP_KEY...${NC}"
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}APP_KEY not set. Generating...${NC}"
    php artisan key:generate --force
    echo -e "${GREEN}APP_KEY generated.${NC}"
else
    echo -e "${GREEN}APP_KEY is set.${NC}"
fi

echo -e "${YELLOW}Step 3: Setting storage permissions...${NC}"
chmod -R 775 storage bootstrap/cache 2>/dev/null || {
    echo -e "${YELLOW}Warning: Could not set permissions. You may need to run: chmod -R 775 storage bootstrap/cache${NC}"
}

echo -e "${YELLOW}Step 4: Clearing all caches...${NC}"
php artisan optimize:clear || {
    echo -e "${RED}Warning: Some cache clear operations failed.${NC}"
}

echo -e "${YELLOW}Step 5: Rebuilding caches...${NC}"
php artisan config:cache || echo -e "${YELLOW}Warning: Config cache failed.${NC}"
php artisan route:cache || echo -e "${YELLOW}Warning: Route cache failed.${NC}"
php artisan view:cache || echo -e "${YELLOW}Warning: View cache failed.${NC}"

echo -e "${YELLOW}Step 6: Optimizing Composer autoload...${NC}"
composer dump-autoload --optimize --no-dev 2>/dev/null || {
    echo -e "${YELLOW}Warning: Composer autoload optimization failed.${NC}"
}

echo -e "${YELLOW}Step 7: Checking database connection...${NC}"
php artisan migrate:status > /dev/null 2>&1 && {
    echo -e "${GREEN}Database connection OK.${NC}"
} || {
    echo -e "${YELLOW}Warning: Database connection failed. Please check your .env database settings.${NC}"
}

echo -e "${GREEN}✅ Deployment fix completed!${NC}"
echo ""
echo "Next steps:"
echo "1. Verify your .env file has all required variables"
echo "2. Check storage/logs/laravel.log for any errors"
echo "3. Test your application: curl http://localhost/up"
echo "4. If issues persist, see docs/EASYPANEL_TROUBLESHOOTING.md"


