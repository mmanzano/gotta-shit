#!/bin/sh
chmod -R 777 storage
php artisan key:generate
php artisan cache:clear