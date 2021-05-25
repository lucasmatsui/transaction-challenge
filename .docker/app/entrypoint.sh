#!/bin/bash

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh

cd /var/www/src

chown -R www-data:www-data .

composer install

php artisan key:generate
php artisan migrate
php artisan db:seed

/usr/bin/supervisord -c /etc/supervisord.conf