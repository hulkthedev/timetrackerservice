#!/usr/bin/env bash
set -e

TTY="-t"
if [[ -n $BAMBOO_AGENT ]]; then
    TTY=""
    USER=""
fi

USER="$(id -u):$(id -g)"

CACHE_DIR="$(realpath "$(pwd)/../composer_cache")"
mkdir -p "${CACHE_DIR}"

DIR=$(dirname "$(readlink -f "$0")")
PROJECTDIR=$(dirname "${DIR}")
cd "${PROJECTDIR}" || exit

docker run --rm \
  ${TTY} \
  --user ${USER} \
  -v "${CACHE_DIR}":/tmp \
  -v "$(pwd)":/app \
  --entrypoint="/bin/bash" composer \
  -c "/usr/bin/composer global require hirak/prestissimo 2>&1; /usr/bin/composer \\
      --ignore-platform-reqs \\
      --prefer-dist \\
      --no-scripts \\
      $* 2>&1"

exit $?
