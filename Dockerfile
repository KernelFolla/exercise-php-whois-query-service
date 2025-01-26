FROM php:8.4.3-fpm-alpine3.20

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# RUN composer install --no-interaction

EXPOSE 9000

CMD ["php-fpm"]
