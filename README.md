## Project description

A lightweight web development environment based on Docker.

The setup consists of two images:
- web server: apache2, php with xdebug
- database server: mariadb

Both images are based on Alpine linux.

## Start development environment

    git clone https://github.com/8ctopus/webdev.git
    cd webdev
    docker-compose up

## Test development environment

Run the scripts in

    http://localhost:8000/

## Get console to containers

### web container
    docker exec -it dev-web zsh

### database container
    docker exec -it dev-db zsh
