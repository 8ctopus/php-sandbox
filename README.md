## project description

A super lightweight LAMP php development environment based on Docker (219 MB).

The setup consists of 2 Docker images:

- web server 40 MB
    - Apache 2.4.43 with SSL
    - php-fpm 7.3.17
    - Xdebug debugging from host
    - composer
    - zsh
- database server 179 MB
    - MariaDB 10.4.12
    - zsh

Both images are based on Alpine Linux.

## cool features

- Apache and php configuration files are exposed on the host.
- Just works with any domain name.
- https is configured out of the box.
- All changes to the config files are automatically applied (hot reload).
- Xdebug is configured for remote debugging (no headaches).

## start development environment

    git clone https://github.com/8ctopus/php-dev.git
    cd php-dev
    docker-compose up

## access website

    http://localhost/
    https://localhost/

## set domain name

To set the domain name to www.test.com, edit the environment variable in the docker-compose file

    environment:
      - DOMAIN=www.test.com

Then edit the system host file (C:\Windows\System32\drivers\etc\hosts). Editing the file requires administrator privileges.

    127.0.0.1 test.net
    127.0.0.1 www.test.net

To access the site

    http://www.test.net/
    https://www.test.net/

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

## Xdebug

The development environment is fully configured to debug php code from the PC.
In the Xdebug client on the computer set the variables as follows:

    host: 127.0.0.1
    port: 9001
    path mapping: "/var/www/site/" : "$GIT_ROOT/dev/"

For path mapping, $GIT_ROOT is the absolute path to where you cloned this
repository in.

## use composer

    docker exec -it dev-web zsh
    composer ...

## install laravel framework

    docker exec -it dev-web zsh
    composer create-project --prefer-dist laravel/laravel blog
    cd blog
    php artisan key:generate
