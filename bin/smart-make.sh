#!/usr/bin/env bash

if ! grep -q docker /proc/1/cgroup; then
  echo "This script is meant to run in a Docker container";
  exit;
fi

php artisan make:$1 $2 -$3
