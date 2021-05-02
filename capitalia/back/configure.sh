chown www-data /var/www/storage -R
chown www-data /var/www/bootstrap/cache -R
php artisan key:generate --force
php artisan jwt:secret --force
php artisan migrate:refresh --seed