#!/bin/sh

# Fail on error
set -e

echo "🚀 Running deployment tasks..."

# Cache the configuration, routes, and views for speed
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
# The --force flag is required for production
# php artisan migrate --force

echo "✅ Tasks complete. Starting Caddy..."

# Start PHP-FPM in the background
php-fpm -D

# Start Caddy in the FOREGROUND (no &)
# This keeps the container running
caddy run --config /var/www/html/render/Caddyfile --adapter caddyfile