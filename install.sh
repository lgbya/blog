#!/usr/bin/env bash

composer install -vvv
php artisan migrate
php artisan db:seed --class=AdminTablesSeeder
php artisan storage:link
