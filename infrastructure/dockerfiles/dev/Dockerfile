FROM php-fpm-alpine:base

LABEL maintainer="fatal.error.27@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        php7-dev

RUN pecl install \
    xdebug-2.9.4

RUN docker-php-ext-enable \
    xdebug

COPY . /tmp/infrastructure

RUN cp /tmp/infrastructure/ini/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    cp /tmp/infrastructure/nginx/dev/logging.conf /etc/nginx/conf.d/logging.conf && \
    rm -rf /tmp/*