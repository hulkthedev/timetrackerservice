#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

cd "${PROJECT_DIR}" || exit

#
# dieses script soll dev + prod image erstellen und pushen
# diese images werden dann in docker-compose bzw. docker-compose.pro YMLs eingetragen statt das Image aus dem
# Dockerfile zu ziehen, dadruch kann auf ein Dockerfile reduziert werden.
#
# gleichzeitig soll das script die YMLs an die aktuellste version anpassen

