#!/bin/sh

cd /usr/share/nginx/html  
php artisan migrate:all
exec "$@"