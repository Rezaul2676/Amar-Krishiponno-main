#!/bin/bash

set -e

cd /var/www/html


# Clear old cache
php artisan optimize:clear || true


# Fix permission on runtime
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache


exec "$@"
