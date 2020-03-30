#!/usr/bin/env bash

set -eo pipefail

PROJECT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
cd "${PROJECT_DIR}" || exit

MODE="dev"
FILE="docker-compose.yml";
if [ "$1" == "prod" ]; then
  MODE="prod"
  FILE="docker-compose.prod.yml";
fi

echo "Mode: ${MODE}"

docker-compose -f "${FILE}" up -d