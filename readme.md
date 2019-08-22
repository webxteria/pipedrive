<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Postman collection

You can get the update collection from here. I have made a small change in payload key name
https://www.getpostman.com/collections/7ea9e50f514c11464aaf

## Setup Project

1) Take the clone
2) RUN ```cp .env.example .env```
3) ```bash vessel init```
4) RUN ```MYSQL_PORT={ANY_PORT} ./vessel start```
5) RUN ```docker exec pipedrive-task_app_1 composer install```
6) RUN ```docker exec pipedrive-task_app_1 php artisan migrate```

## Up Docker containers

```./vessel start```

## Down docker containers

```./vessel down```

## Run Tests

I have used In-memory to run test cases and refresh data every time cases started.

```docker exec -it pipedrive-task_app_1 ./vendor/bin/phpunit ``



