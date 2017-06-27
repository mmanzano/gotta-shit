#!/bin/sh
chmod -R 777 storage
composer install --no-dev
if [ ! -f key_generate ]; then
    php artisan key:generate
    touch key_generate
fi
composer dump-autoload
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan migrate --force
