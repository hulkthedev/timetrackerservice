FROM php-fpm-alpine:7.4.4-prod

LABEL maintainer="fatal.error.27@gmail.com"

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R u+rw /var/www/html