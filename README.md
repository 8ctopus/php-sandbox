# php sandbox

A super lightweight LAMP (Linux, Apache, MySQL, PHP) php development environment based on Docker.

## features

- php 8.2.0 RC2, 8.1, 8.0 or 7.4
- Just works with any domain name and https is configured out of the box
- All changes to config files are automatically applied (hot reload)
- Xdebug is configured for php step by step debugging in VSCode
- Profile php code with SPX
- Javascript step by step debugging in VSCode

_Note_: On Windows [hot reload doesn't work with WSL 2](https://github.com/microsoft/WSL/issues/4739), you need to use the legacy Hyper-V.

## setup

The setup consists of 2 Docker images with a combined size of 100 MB.

- web server ![Docker Image Size (latest semver)](https://img.shields.io/docker/image-size/8ct8pus/apache-php-fpm-alpine?sort=semver)
    - Apache 2.4.54 with SSL
    - php-fpm 8.2.0 RC2, 8.1.10, 8.0.17 or 7.4.21
    - Xdebug 3.2.0 alpha 3 - debugger and profiler
    - [SPX prolifer 0.4.12](https://github.com/NoiseByNorthwest/php-spx)
    - composer 2.4.2
    - zsh 5.9
    - Alpine 3.16.2

- database server ![Docker Image Size (latest semver)](https://img.shields.io/docker/image-size/8ct8pus/mariadb-alpine?sort=semver)
    - MariaDB 10.6.10
    - zsh 5.9
    - Alpine 3.16.2

## install

You can either [download the latest version](https://github.com/8ctopus/php-sandbox/tags) or `git clone` the repository.

```sh
git clone --depth 1 https://github.com/8ctopus/php-sandbox.git
```

## start coding

Start `Docker Desktop` then:

```sh
cd php-sandbox

# edit `docker-compose.yml` to use php 7.4, 8.0, 8.1 no changes required for php 8.2.

# start containers in detached mode on Windows in cmd
start /B docker-compose up

# start containers in detached mode on linux and mac in shell
docker-compose up &

# open browser
http://localhost/
```

## source code

All your source code goes inside the `html` directory. The `public` sub-directory is the web server `DOCUMENT_ROOT` (files servable by Apache server).

## set domain name

To set the domain name to www.test.com, edit the environment variable in the `docker-compose.yml` file

    environment:
      - DOMAIN=www.test.com

Add this line to the system host file. Editing the file requires administrator privileges.

    C:\Windows\System32\drivers\etc\hosts

    127.0.0.1 test.net www.test.net

## add https

To remove "Your connection is not private" nag screens, import the certificate authority file under ssl/certificate_authority.pem in the browser's certificates under Trusted Root Certification Authorities.

guide: https://support.globalsign.com/digital-certificates/digital-certificate-installation/install-client-digital-certificate-windows-using-chrome

## Xdebug debugger

This repository is configured to debug php code in Visual Studio Code. To start debugging, open the VSCode workspace then select `Run > Start debugging` then open the site in the browser.
The default config is to stop on entry which stops at the first line in the file. To only stop on breakpoints, set `stopOnEntry` to `false` in `.vscode/launch.json`.

For other IDEs, set the Xdebug debugging port to `9001`.

To troubleshoot debugger issues, check the `docker/log/xdebug.log` file.

If `host.docker.internal` does not resolve within the container, update the xdebug client host within `docker/etc/php/conf.d/xdebug.ini` to the docker host ip address.

```ini
xdebug.client_host = 192.168.65.2
```

## Code profiling

Code profiling comes in 2 variants.

_Note_: Disable Xdebug debugger `xdebug.remote_enable` for accurate measurements.

## Xdebug

To start profiling, add the `XDEBUG_PROFILE` variable to the request as a GET, POST or COOKIE.

    http://localhost/?XDEBUG_PROFILE

Profiles are stored in the `log` directory and can be analyzed with tools such as [webgrind](https://github.com/jokkedk/webgrind).

## SPX

- Access the [SPX control panel](http://localhost/?SPX_KEY=dev&SPX_UI_URI=/)
- Check checkbox `Whether to enable SPX profiler for your current browser session. No performance impact for other clients.`
- Run the script to profile
- Refresh the SPX control panel tab and the report will be available at the bottom of the screen. Click it to show the report in a new tab.

## connect to database

```
hostname: localhost / sandbox-db
user: root
password: 123
port: 3306
```

## access container

```sh
# web container
docker exec -it sandbox zsh

# database container
docker exec -it sandbox-db zsh
```

## more docker commands

```sh
# view logs
docker-compose logs -f

# stop containers
docker-compose stop

# delete containers
docker-compose down

# delete containers and volume (deletes database)
docker-compose down -v

## get shell access to container
docker exec -it sandbox zsh
docker exec -it sandbox-db zsh
```

## extend docker image

In this example, we add the php-curl extension.

```sh
docker-compose up --detach
docker exec -it sandbox zsh
apk add php-curl
exit

docker-compose stop
docker commit sandbox sandbox-curl:dev
```

To use this image, update the reference in `docker-compose.yml`.
