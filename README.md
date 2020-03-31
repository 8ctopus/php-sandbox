## project description

A super lightweight php development environment based on Docker (253Mb).

The setup consists of two images:
- web server 65Mb
    - apache 2.4.41
    - php 7.3.16 with xdebug
    - composer
    - zsh
- database server 188Mb
    - MariaDB 10.4.12
    - zsh

Both images are based on Alpine linux.

## cool feature

Apache, php and MariaDB configuration files are all exposed on the host computer and all changes are immediately applied.

## start development environment

    git clone https://github.com/8ctopus/webdev.git
    cd webdev
    docker build -t 8ctopus/apache-php:latest apache-php
    docker build -t 8ctopus/mariadb:latest mariadb
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
