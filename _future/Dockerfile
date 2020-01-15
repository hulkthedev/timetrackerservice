FROM php:7.4.1-fpm-alpine3.10

LABEL time.tracker.maintainer="fatal.error.27@gmail.com"

COPY . /var/www/html

RUN usermod -u 1000 www-data \
    && chown -R www-data:www-data /var/www/html