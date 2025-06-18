#!/bin/sh

set -e

if [ ! -z "$SET_UID" ] && [ ! -z "$SET_GID" ]; then
    chown -R "$SET_UID:$SET_GID" storage bootstrap/cache
else
    chown -R www-data:www-data storage bootstrap/cache
fi

if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" ]; then
    php artisan key:generate
fi

exec php-fpm
