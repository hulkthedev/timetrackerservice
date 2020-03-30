FROM php-fpm-alpine:base

LABEL maintainer="fatal.error.27@gmail.com"

COPY . /tmp/infrastructure

RUN cp /tmp/infrastructure/nginx/prod/logging.conf /etc/nginx/conf.d/logging.conf && \
    rm -rf /tmp/*