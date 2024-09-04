#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# Pull the latest version of the app
# git pull origin main
git fetch origin
git pull origin main
git clean -fdX

# Install composer dependencies
#composer install

# Clear the old cache
php artisan optimize

# Run database migrations and seed
#php artisan migrate:fresh --seed

# Exit maintenance mode
php artisan up

# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=8000

echo "Deployment finished!"
