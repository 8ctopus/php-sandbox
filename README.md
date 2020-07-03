## project description

A super lightweight LAMP development environment based on Docker (219 MB).

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
- All changes to config files are automatically applied (hot reload).
- Xdebug is configured for remote debugging (no headaches).

## start development environment

    docker-compose up

## access website

    http://localhost/
    https://localhost/

## set domain name

To set the domain name to www.test.com, edit the environment variable in the docker-compose file

    environment:
      - DOMAIN=www.test.com

Add this line to the system host file. Editing the file requires administrator privileges.

    C:\Windows\System32\drivers\etc\hosts

    127.0.0.1 test.net www.test.net

## https

To remove "Your connection is not private" nag screens, import the certificate authority file under ssl/certificate_authority.pem in your browser's certificates under Trusted Root Certification Authorities. (https://support.globalsign.com/digital-certificates/digital-certificate-installation/install-client-digital-certificate-windows-using-chrome)

## Xdebug

The docker image is fully configured to debug php code from the computer. The necessary configuration for Visual Studio Code is already installed. For other IDEs, configure the Xdebug client as follows:

    host: 127.0.0.1
    port: 9001
    path mapping: "/var/www/site/" : "$GIT_ROOT/dev/"

For path mapping, $GIT_ROOT is the absolute path to where you cloned this
repository in.

## get console to containers

### web container

    docker exec -it sandbox zsh

### database container

    docker exec -it sandbox-db zsh

## use composer

    docker exec -it sandbox zsh
    composer install

## connect to database

    hostname: localhost
    user: root
    password: 123
    port: 3306

## extend the docker images

As an example, let's add the php-curl extension.

    docker exec -it sandbox zsh
    apk add php-curl
    exit
    docker-compose stop
    docker commit sandbox:dev

To use the new image, update the image link in the docker-compose file.

## install laravel framework

    docker exec -it sandbox zsh
    composer create-project --prefer-dist laravel/laravel blog
    cd blog
    php artisan key:generate
