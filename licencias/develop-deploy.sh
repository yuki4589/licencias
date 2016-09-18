#!/bin/sh
chmod -R 770 storage
chmod -R 770 bootstrap/cache
if [ ! -f key_generate ]; then
    php artisan key:generate
    touch key_generate
fi
php artisan cache:clear
php artisan migrate:refresh --seed --force