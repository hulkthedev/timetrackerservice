FROM php:7.4.4-fpm-alpine3.11

LABEL maintainer="fatal.error.27@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        $PHPIZE_DEPS \
        bash

RUN pecl install \
        apcu-5.1.18

RUN docker-php-ext-install \
        pdo_mysql \
        opcache \
    && \
    docker-php-ext-enable \
        apcu

RUN echo Europe/Berlin > /etc/timezone

RUN mkdir /etc/nginx && \
    mkdir /etc/nginx/conf.d

COPY . /tmp/infrastructure

RUN cp /tmp/infrastructure/ini/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini && \
    cp /tmp/infrastructure/ini/docker-php-ext-apcu.ini /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini && \
    rm -rf /tmp/*