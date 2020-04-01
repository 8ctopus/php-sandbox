## project description

A super lightweight php development environment based on Docker (253 MB).

The setup consists of 2 Docker images:

- web server 65 MB
    - apache 2.4.41
    - php 7.3.16 with xdebug
    - composer
    - zsh
- database server 188 MB
    - MariaDB 10.4.12
    - zsh

Both images are based on Alpine Linux.

## cool feature

- Apache, php and MariaDB configuration files are exposed on the host.
- All changes to the config files are automatically applied (hot reload).

## start development environment

    git clone https://github.com/8ctopus/webdev.git
    cd webdev
    docker-compose up

## test development environment

Run the scripts in

    http://localhost:8000/

## connect to database

    hostname: localhost
    user: root
    password: 123
    port: 3306

## get console to containers

### web container
    docker exec -it dev-web zsh

### database container
    docker exec -it dev-db zsh

## use composer
    docker exec -it dev-web zsh
    composer ...

## install laravel framework
    docker exec -it dev-web zsh
    composer create-project --prefer-dist laravel/laravel blog
    cd blog
    php artisan key:generate
