<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Setup Project

1) Take the clone
2) RUN ```cp .env.example .env```
3) ```bash vessel init```
4) RUN ```MYSQL_PORT={ANY_PORT} ./vessel start```
5) RUN ```docker exec pipedrive-task_app_1 composer install```
6) RUN ```docker exec pipedrive-task_app_1 php artisan migrate```

## Down docker containers

```./vessel down```

## Up Docker containers

```./vessel start```


