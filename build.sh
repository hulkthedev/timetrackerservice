#!/usr/bin/env bash

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

# install composer
chmod +x composer.sh
./composer.sh install --no-scripts

# run unit tests
chmod +x phpunit.sh
./phpunit.sh

# add push hook
chmod +x hook.sh
./hook.sh