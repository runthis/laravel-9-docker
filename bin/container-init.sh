#!/usr/bin/env bash

if ! grep -q docker /proc/1/cgroup; then
  echo "This script is meant to run in a Docker container";
  exit;
fi

RED='\033[38;5;1m'
YELLOW='\033[38;5;3m'
GREEN='\033[38;5;2m'
CYAN='\033[38;5;6m'
RESET='\033[0m'

stderr_print() {
    printf "%b\\n" "${*}" >&2
}

log() {
    stderr_print "$(date "+%T.%2N ") ${*}"
}

info() {
    log "${CYAN}${*}${RESET}"
}

warn() {
    log "${YELLOW}${*}${RESET}"
}

error() {
    log "${RED}${*}${RESET}"
}

success() {
    log "${GREEN}${*}${RESET}"
}

cmd_run() {
    cmd_data=$("$@" 2>&1)
    local cmd_code=$?
    if [[ "$cmd_code" -ne 0 ]]; then
        error "${cmd_data}"
    fi
}

wait_for_db() {
    local db_host="${DB_HOST:-mariadb}"
    local db_port="${DB_PORT:-3306}"
    local db_address=$(getent hosts "$db_host" | awk '{ print $1 }')
    local counter=0
	local timer
    info "Connecting to database instance: ${db_address}:${db_port}"
    while ! nc -z "$db_address" "$db_port" >/dev/null; do
        counter=$((counter + 1))

        if [ "${counter}" == 30 ]; then
            error "Could not connect to database instance within 60 seconds: ${db_address}:${db_port}"
            exit 1
        fi

        sleep 2
    done

    success "Connected to database instance: ${db_address}:${db_port}"
}

# Run composer install if we have no vendors
if [ -d "/app/vendor" ]; then
    info "Running composer autoload"
    cmd_run composer dump-autoload
else
    warn "Running composer install"
    cmd_run composer install
fi

# Initial setup for Laravel
# Only run once so we don't run migrations when we don't want to
if [ -f ".env.dev" ]; then
    if [ ! -f ".env" ]; then
        info "Setting up .env"
        cmd_run cp .env.dev .env

        # Something went wrong?
        if [ -d "/app/vendor" ]; then
            composer install
        fi

		info "Running key generation in laravel artisan"
		cmd_run php artisan key:generate --ansi

        # Wait until we have a good database connection before continuing
        wait_for_db

		warn "Running database migrations"
		php artisan migrate --force
    fi
fi

# Run npm install if we have no node_modules
if [ ! -d "/app/node_modules" ]; then
    warn "Running npm install"
    cmd_run npm install
fi

# Wait until we have a good database connection before continuing
wait_for_db

if [ ! -f "/app/public/mix-manifest.json" ]; then
    info "Compiling assets"
    cmd_run npm run dev
fi

# Go go gadget
php artisan serve --host=0.0.0.0 --port=3005
