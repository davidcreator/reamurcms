#!/bin/bash
# docker/php/docker-entrypoint.sh
# ReamurCMS — Container Startup Script
#
# Runs every time the container starts.
# Handles config file setup and permissions before Apache launches.

set -e

echo ""
echo "╔══════════════════════════════════════╗"
echo "║        ReamurCMS — Starting          ║"
echo "╚══════════════════════════════════════╝"
echo ""

# ─────────────────────────────────────────
# 1. Copy config files if not present
# ─────────────────────────────────────────
echo "→ Checking configuration files..."

if [ ! -f config.php ] && [ -f config-dist.php ]; then
    cp config-dist.php config.php
    echo "  ✅ config.php created from config-dist.php"
elif [ -f config.php ]; then
    echo "  ✅ config.php already exists — skipping"
else
    echo "  ⚠️  config-dist.php not found — skipping frontend config"
fi

if [ ! -f admin/config.php ] && [ -f admin/config-dist.php ]; then
    cp admin/config-dist.php admin/config.php
    echo "  ✅ admin/config.php created from admin/config-dist.php"
elif [ -f admin/config.php ]; then
    echo "  ✅ admin/config.php already exists — skipping"
else
    echo "  ⚠️  admin/config-dist.php not found — skipping admin config"
fi

# ─────────────────────────────────────────
# 2. Install/update Composer dependencies
# ─────────────────────────────────────────
echo ""
echo "→ Installing Composer dependencies..."

if [ -f system/storage/composer.json ]; then
    cd system/storage

    if [ "${APP_ENV}" = "development" ]; then
        composer install --no-interaction --prefer-dist
    else
        composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader
    fi

    echo "  ✅ Composer dependencies installed"
    cd /var/www/html
else
    echo "  ⚠️  system/storage/composer.json not found — skipping Composer install"
fi

# ─────────────────────────────────────────
# 3. Fix directory permissions
# ─────────────────────────────────────────
echo ""
echo "→ Setting permissions..."

# Directories that need write access
WRITABLE_DIRS=(
    "system/storage/cache"
    "system/storage/logs"
    "system/storage/download"
    "system/storage/upload"
    "image"
)

for dir in "${WRITABLE_DIRS[@]}"; do
    if [ -d "$dir" ]; then
        chown -R www-data:www-data "$dir"
        chmod -R 775 "$dir"
        echo "  ✅ $dir"
    else
        mkdir -p "$dir"
        chown -R www-data:www-data "$dir"
        chmod -R 775 "$dir"
        echo "  ✅ $dir (created)"
    fi
done

# ─────────────────────────────────────────
# 4. Ready
# ─────────────────────────────────────────
echo ""
echo "╔══════════════════════════════════════╗"
echo "║   ReamurCMS ready on port 80 🚀      ║"
echo "╚══════════════════════════════════════╝"
echo ""
echo "  App       → http://localhost:8080"
echo "  Admin     → http://localhost:8080/admin"
echo "  phpMyAdmin→ http://localhost:8081"
echo "  MailHog   → http://localhost:8025"
echo ""

# Hand off to the main process (apache2-foreground)
exec "$@"
