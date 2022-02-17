#!/usr/bin/env bash

if ! grep -q docker /proc/1/cgroup; then
  echo "This script is meant to run in a Docker container";
  exit;
fi

GREEN='\033[38;5;2m'
CYAN='\033[38;5;6m'
RESET='\033[0m'

printf "\nWaiting for site "

while :; do
    cmd_data=$(curl -s localhost:3005)
    cmd_code=$?
    if [[ "$cmd_code" -ne 0 ]]; then
        printf "."
        sleep 1
    else
        printf " ${GREEN}done${RESET}\n\n\n"
        echo -e "Site URL:   ${CYAN}http://localhost:3005${RESET}"
        echo -e "PHPMyAdmin: ${CYAN}http://localhost:3010${RESET}\n\n"
        break
    fi
done
