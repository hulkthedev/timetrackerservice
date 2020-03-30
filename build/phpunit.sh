#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

SERVICE=timetrackerservice_timetrackerservice-php_1
CONTAINER=$(docker ps -qf "name=${SERVICE}")

if [[ $CONTAINER == '' ]]; then
    echo "Starting ${SERVICE}..."
    cd "${PROJECT_DIR}" || exit
    docker-compose up -d
fi

echo "Starting PHPUnit Tests..."

docker exec -i ${SERVICE} ./vendor/bin/phpunit \
    --colors=always \
    --configuration tests \
    --coverage-clover=clover.xml \
    --log-junit junit.xml

exit $?

RESULT=$?
exit ${RESULT}

