FROM XXX

LABEL time.tracker.maintainer="fatal.error.27@gmail.com"

COPY . /var/www/html

RUN mkdir -p /var/www/html/app/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R u+rw /var/www/html
