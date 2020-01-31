#!/usr/bin/env bash

USER="--user $(id -u):$(id -g)"
CACHE_DIR="--volume $(pwd)/../composer_cache:/tmp"

docker run \
  --rm \
  ${USER} \
  ${CACHE_DIR} \
  -v $(pwd):/app \
    composer "$@" \
      --ignore-platform-reqs \
      --optimize-autoloader \
      --prefer-dist

exit $?
