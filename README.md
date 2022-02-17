# Laravel 9 Docker Template

[![PHP Tests](https://github.com/runthis/laravel-9-docker/actions/workflows/php.yml/badge.svg)](https://github.com/runthis/laravel-9-docker/actions/workflows/php.yml)

This is a docker template for local development using [Laravel 9](https://laravel.com/docs/9.x). It is *opinionated* and using [Laravel Socialite](https://laravel.com/docs/9.x/socialite) with pre-setup Google Authentication. You should [setup credentials in google](https://console.cloud.google.com/apis/credentials?) and then add the following keys to your `.env` file *(not the other .env.* files)* so you can authenticate through Google, or don't and roll your own:

    GOOGLE_CLIENT_ID="clientidhere.apps.googleusercontent.com"
    GOOGLE_CLIENT_SECRET="secrethere"

## Setup
**1. Clone the repo**

`git clone git@github.com:runthis/laravel-9-docker.git laravel-9-docker && cd laravel-9-docker`

**2. Build the container**

`npm run container:build`

## Access

**Open the browser and see "hello world"**

`http://localhost:3005/`

**Use PHPMyAdmin if you want**

`http://localhost:3010/`


## Useful commands

This is not an exhaustive list. Use `npm run` to see a list of all commands.

| Command | Description |
|--|--|
| `npm run composer` | Run composer commands |
| `npm run artisan` | Run artisan commands |
| `npm run shell` | Access the container |
| `npm run dev` | Quickly build the frontend |
| `npm run prod` | Build the frontend for production |
| `npm run migrate` | Run database migrations |
| `npm run migrate:undo` | Undo the last migration |
| `npm run migrate:refresh` | Wipe and redo database migrations |
| `npm run test` | Run unit/feature tests |
| `npm run phpcs` | Run phpcs tests |

*Additionally commands can be run using `docker-compose exec` for example

 `docker-compose exec laravel php -i` will show PHP info.*

## Future updates
I will update this from time to time to resolve security issues / vendor updates. Although it is unlikely I'll add specifically new features, but rather use this template as a blank slate / baseline to create new Laravel packages that can be used as vendors. Will update this readme if/when a new package created is compatible with this repo.
