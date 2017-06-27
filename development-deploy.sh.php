#!/bin/sh
composer update
chmod -R 777 storage

php artisan key:generate
php artisan migrate:refresh --seed
php artisan view:clear
php artisan route:clear
php artisan cache:clear