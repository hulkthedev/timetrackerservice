#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

CACHE_VOLUME=timetrackerservice-composer-cache

IMAGE="composer"
TAG="1.10.1"

docker volume create --name ${CACHE_VOLUME} &> /dev/null

docker run --rm -i -t \
    -v ${CACHE_VOLUME}:/tmp \
    -v "${PROJECT_DIR}":/app \
    -w="/app" \
    --entrypoint="/bin/bash" \
    "${IMAGE}:${TAG}" \
    -c "/usr/bin/composer global require hirak/prestissimo &> /dev/null; /usr/bin/composer $*"

RESULT=$?

echo

exit ${RESULT}