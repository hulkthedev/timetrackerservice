FROM php:7.4.1-fpm-alpine3.10
LABEL maintainer="fatal.error.27@gmail.com"

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R u+rw /var/www/html