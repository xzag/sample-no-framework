#!/usr/bin/env bash

./getcomposer.sh

php composer.phar install

php -r "file_exists('.env') || copy('.env.dist', '.env');"

php -S localhost:8080 -t public/
