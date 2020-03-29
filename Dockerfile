FROM php:7.4.1-fpm-alpine3.10

LABEL maintainer="fatal.error.27@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        $PHPIZE_DEPS \
        bash \
        php7-dev

RUN pecl install xdebug-2.9.4 && \
    docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql

RUN echo Europe/Berlin > /etc/timezone

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R u+rw /var/www/html