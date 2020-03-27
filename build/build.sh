#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

cd "${PROJECT_DIR}" || exit

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

cd "${BUILD_DIR}" || exit

# install composer
chmod +x composer.sh
./composer.sh install \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --no-suggest \
    --apcu-autoloader \
    --optimize-autoloader

# run unit tests
chmod +x phpunit.sh
./phpunit.sh

# add push hook
chmod +x hook.sh
./hook.sh