#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

php artisan config:clear

echo "Caching routes..."
php artisan route:cache

php artisan route:clear

echo "Running migrations..."
php artisan migrate --force

echo "Running laravel passport..."
php artisan passport:install --force
