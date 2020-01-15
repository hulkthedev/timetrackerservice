#!/usr/bin/env bash

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

# install composer
./composer.sh install --no-scripts
