#!/usr/bin/env bash

echo "Starting PHPUnit Tests..."

docker run -i \
    --rm \
    --volume `pwd`:/var/www/html \
    --entrypoint "/usr/local/bin/php" \
    dockerregistry.arvato-cp.com/team-c/wishlistservice:7.3.11-fpm-stretch-dev \
        ./vendor/bin/phpunit \
            --configuration tests/unit/phpunit.xml \
            --colors=always \
            --coverage-clover=clover.xml \
            --log-junit junit.xml \
            $@

RESULT=$?

exit ${RESULT}