#!/bin/sh
chmod -R 777 storage
composer update
if [[ -f key_generate ]]; then
    php artisan key:generate
    touch key_generate
fi
php artisan cache:clear