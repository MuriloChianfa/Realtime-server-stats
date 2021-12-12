#!/usr/bin/env sh
set -eu

composer install
composer update
composer fund

exec "$@"

