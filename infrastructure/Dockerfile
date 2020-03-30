FROM php:7.4.4-fpm-alpine3.11

LABEL maintainer="fatal.error.27@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        bash

RUN docker-php-ext-install pdo_mysql

RUN echo Europe/Berlin > /etc/timezone

RUN mkdir /etc/nginx && \
    mkdir /etc/nginx/conf.d