# php sandbox

A super lightweight LAMP (Linux Apache MySQL PHP) development environment based on Docker (approx 250 MB).

The setup consists of 2 Docker images:

- web server 61 MB
    - Apache 2.4.52 with SSL
    - php-fpm 8.0.14 or 7.4.21
    - Xdebug 3.1.2 - debugger and profiler
    - [SPX prolifer 0.4.11](https://github.com/NoiseByNorthwest/php-spx)
    - composer 2.1.12
    - zsh 5.8
    - Alpine 3.15.0

- database server 195 MB
    - MariaDB 10.6.4
    - zsh 5.8
    - Alpine 3.15.0

## cool features

- php 8.0 or 7.4
- Just works with any domain name and https is configured out of the box
- All changes to config files are automatically applied (hot reload)
- Xdebug is configured for php step by step debugging in VSCode
- Profile php code with SPX
- Javascript step by step debugging in VSCode

_Note_: On Windows [hot reload doesn't work with WSL 2](https://github.com/microsoft/WSL/issues/4739), you need to use the legacy Hyper-V.

## download php sandbox

You can either download the latest version from the `tags` within the `Releases` section in the right sidebar or `git clone` the repository.

```sh
git clone --depth 1 https://github.com/8ctopus/php-sandbox.git
```

## start developing

Start docker desktop then:

```sh
cd php-sandbox

# edit `docker-compose.yml` to use php 7.4, no changes required for php 8.0.

# start containers in detached mode on Windows in cmd
start /B docker-compose up

# start containers in detached mode on linux and mac in shell
docker-compose up &

# open browser
http://localhost/
```

## source code

All your source code goes inside the `html` directory. The `public` sub-directory is the web server `DOCUMENT_ROOT` (visible files).

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

## website domain name

To set the domain name to www.test.com, edit the environment variable in the `docker-compose.yml` file

    environment:
      - DOMAIN=www.test.com

Add this line to the system host file. Editing the file requires administrator privileges.

    C:\Windows\System32\drivers\etc\hosts

    127.0.0.1 test.net www.test.net

## https

To remove "Your connection is not private" nag screens, import the certificate authority file under ssl/certificate_authority.pem in the browser's certificates under Trusted Root Certification Authorities.

guide: https://support.globalsign.com/digital-certificates/digital-certificate-installation/install-client-digital-certificate-windows-using-chrome

## Xdebug debugger

This repository is configured to debug php code in Visual Studio Code. To start debugging, open the VSCode workspace then select `Run > Start debugging` then open the site in the browser. The default config is to stop on entry which stops at the first line in the file. To only stop on breakpoints, set `stopOnEntry` to `false` in `.vscode/launch.json`.

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

## access containers through command line

```sh
# web container
docker exec -it sandbox zsh

# database container
docker exec -it sandbox-db zsh
```

## use composer

```sh
docker exec -it sandbox zsh
composer install
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
