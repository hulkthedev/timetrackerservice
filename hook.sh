rm -f .git/hooks/pre-commit
rm -f .git/hooks/pre-push

echo "#! /usr/bin/env bash

./phpunit.sh

if [ \$? -ge 1 ]
then
    echo 'PHPUnit Tests failed!'
    exit 1
else
    echo 'PHPUnit Tests passed!'
fi" >.git/hooks/pre-push

chmod +x .git/hooks/pre-push
