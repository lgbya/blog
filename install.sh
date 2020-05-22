#!/usr/bin/env bash

chmod -R 777 ./storage
composer install -vvv
php artisan migrate
php artisan db:seed --class=AdminTablesSeeder
php artisan key:generate
php artisan storage:link
