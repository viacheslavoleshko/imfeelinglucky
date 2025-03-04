# imfeelinglucky

## Description 

This project is a Laravel-based web application that leverages Laravel Sanctum for API authentication. It includes features for user registration, login, and logout, as well as generating temporary signed URLs for secure access to specific routes. The application also includes a lottery system where users can participate and view their results. The project is structured with a focus on clean code and maintainability, utilizing Laravel's powerful routing, middleware, and service container features.

##  First Install

1) `git clone <path to remote repositiry> imfeelinglucky`
2) `cd imfeelinglucky`
3) `cp .env.example .env`
4) Change credentials in `.env` file if you need
5) `docker-compose build`
6) `docker-compose up  -d`
7) `docker ps`
8)  Find \<container-id\> `imfeelinglucky-php-fpm-1`
9)  `docker exec -it  <container-id> bash`
10) `composer install`
11) `php artisan migrate  --seed`
12) `php artisan key:generate`
13) `exit`
14) `sudo chmod -R 777 storage`
15) `sudo chmod -R 777 bootstrap/cache/`

## Updating

1) `cd <path-to-folder-imfeelinglucky>`
2) `git pull`
3) `docker ps`
4) Find \<container-id\> `imfeelinglucky-php-fpm-1`
5) `docker exec -it  <container-id> bash`
6) `composer install` if you need
7) `php artisan migrate`
8) `queue:restart` to restart current queue workers after code updating


## Running the Scheduler

1) `php artisan schedule:work` to start scheduler

Queues will be working automatically

You can change `QUEUE_CONNECTION` in `.env` if you need


## Project support

> Request docs & OpenAPI: `/request-docs`

> Also you can interesting in: [MySQL database schema](https://drawsql.app/teams/test-4184/diagrams/imfeelinglucky)


- Register: `api/v1/auth/register`
- Login: `api/v1/auth/login`
- Logout: `api/v1/auth/logout`
- Regenerate unique URL token: `api/v1/token/{token}/regenerate`
- Revoke unique URL token: `api/v1/token/{token}/revoke`
- Get last 3 results of your tries: `api/v1/lottery/{token}/history`
- Try your luck in the game: `api/v1/lottery/{token}/ticket`

## Steps to use

1) Register using your `username`, `phonenumber` and `password`
2) Put your `access_token` in header `-H "Authorization: Bearer access_token"`
3) Put your `url_token` as `token` attribute while using specified routes

> Revoking the token will block access for all special routes and you will no longer be able to use them 

> You can change expiration time in minutes for `access_token` by adding `SANCTUM_EXPIRATION` in `.env`

> You can change expiration time in minutes for `url_token` by adding `URL_TOKEN_EXPIRATION_TIME` in `.env`