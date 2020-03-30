## project description

A super lightweight web development environment based on Docker (253Mb).

The setup consists of two images:
- web server: apache2, php with xdebug - 65Mb
- database server: mariadb - 188Mb

Both images are based on Alpine linux.

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
