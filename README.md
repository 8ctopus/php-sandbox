# php sandbox

A lightweight `php` sandbox for learning, testing and debugging code.

![php sandbox screenshot](https://github.com/8ctopus/php-sandbox/raw/master/screenshot.png)

## features

- `Alpine Linux`, `Apache`, `php-fpm` and `MariaDB` (LAMP)
- php `8.3`, `8.2`, `8.1`, `8.0`, `7.4` along with the most commonly used extensions
- Just works with any domain name and https is configured out of the box
- Support for multiple virtual hosts
- php `code cleanup` using `php cs fixer`
- php code static analysis using `phpmd` and `phpstan`
- profile php code with [SPX profiler](https://github.com/NoiseByNorthwest/php-spx) or Xdebug
- Apache and php configuration files are exposed on the host for easy edit
- all changes to configuration files are automatically applied inside the container (hot reload)
- `Xdebug` is configured for step by step debugging and profiling in Visual Studio Code
- `javascript` step by step debugging in Visual Studio Code

## architecture

The setup consists of 2 Docker images with a combined size of approximately 110 MB.

- web server ![Docker Image Size (latest semver)](https://img.shields.io/docker/image-size/8ct8pus/apache-php-fpm-alpine?sort=semver)
    - `Apache` 2.4.59 with SSL
    - `php-fpm` 8.3.7
    - `Xdebug` 3.3.2 - debugger and profiler
    - [`SPX` prolifer dev-master](https://github.com/NoiseByNorthwest/php-spx)
    - `composer` 2.6.5
    - `zsh` 5.9
    - `Alpine` 3.19.1 with edge repositories

- database server ![Docker Image Size (latest semver)](https://img.shields.io/docker/image-size/8ct8pus/mariadb-alpine?sort=semver)
    - `MariaDB` 10.6.12
    - `zsh` 5.9
    - `Alpine` 3.17.2

## install

You can either [download the latest version](https://github.com/8ctopus/php-sandbox/tags) or `git clone` the repository.

    git clone --depth 1 https://github.com/8ctopus/php-sandbox.git

For php `8.2` or `8.1`, select the image in `docker-compose.yml`. For older php version, you need to download an [older version of php-sandbox](https://github.com/8ctopus/php-sandbox/releases/tag/1.2.8) and then choose the correct php version in `docker-compose.yml` as the architecture changed since.

## start coding

Start `Docker Desktop` then:

    cd php-sandbox

    # start containers in detached mode on Windows in cmd
    start /B docker-compose up

    # start containers in detached mode on linux and mac in shell
    docker-compose up &

_Note_: On Windows [file changes notification to the container doesn't work with the WSL 2 engine](https://github.com/8ctopus/apache-php-fpm-alpine/issues), you need to use the `Hyper-V` engine. Uncheck `Use WSL 2 based engine`. What this means, is that files you update on Windows are not updated inside the container unless you use `Hyper-V`.

## access sites

By default, there are 2 sites you can access from your browser

    http(s)://localhost/
    http(s)://(www.)test.com/

The source code is located inside the `sites/*/html/public/` directories.

## domain names

Setting a domain name is done by using virtual hosts. The virtual hosts configuration files are located in `sites/config/vhosts/`. By default, `localhost` and `test.com` are already defined as virtual hosts.

For your browser to resolve `test.com`, add this line to your system's host file. Editing the file requires administrator privileges.\
\
On Windows: `C:\Windows\System32\drivers\etc\hosts`\
Linux and Mac: `/etc/hosts`

    127.0.0.1 test.com www.test.com

## https

A self-signed https certificate is already configured for `localhost` and `test.com`.\
To remove "Your connection is not private" nag screens, import the certificate authority file `sites/config/ssl/certificate_authority.pem` to your computer's Trusted Root Certification Authorities then restart your browser.

In Windows, open `certmgr.msc` > click `Trusted Root Certification Authorities`, then right click on that folder and select `Import...` under `All Tasks`.

On Linux and Mac: \[fill blank\]

For newly created domains, you will need to create the SSL certificate:

```sh
docker-exec -it web zsh
selfsign certificate /sites/domain/ssl domain.com,www.domain.com,api.domain.com /sites/config/ssl
```

_Note_: Importing the certificate authority creates a security risk since all certificates issued by this new authority are shown as perfectly valid in your browsers.

## Xdebug debugger

This repository is configured to debug php code in Visual Studio Code. To start debugging, open the VSCode workspace then select `Run > Start debugging` then open the site in the browser.\
The default config is to stop on entry which stops at the first line in the file. To only stop on breakpoints, set `stopOnEntry` to `false` in `.vscode/launch.json`.

For other IDEs, set the Xdebug debugging port to `9001`.

To troubleshoot debugger issues, check the `sites/localhost/logs/xdebug.log` file.

If `host.docker.internal` does not resolve within the container, update the xdebug client host within `docker/etc/php/conf.d/xdebug.ini` to the docker host ip address.

```ini
xdebug.client_host = 192.168.65.2
```

## code cleanup

[PHP Coding Standards Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) is a tool to automatically fix PHP coding standards issues.

    cd sites/localhost/html
    composer fix(-risky)

## check code for issues

[PHPStan](https://github.com/phpstan/phpstan) is a PHP static analysis tool, it can discover bugs in your code without running it

    cd sites/localhost/html
    composer phpstan

## code profiling

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

## database access

You can connect to the database using your favorite MySQL client (on Windows, [HeidiSQL](https://github.com/HeidiSQL/HeidiSQL) for example)

    hostname: localhost / sandbox-db
    user: root
    password: 123
    port: 3306

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

## extend the docker image

In this example, we add the `php-curl` extension.

```sh
docker-compose up --detach
docker exec -it sandbox zsh
apk add php-curl
exit

docker-compose stop
docker commit sandbox sandbox-curl:dev
```

To use this image, update the reference in `docker-compose.yml`.

## Sublime Text

If you like Sublime Text, checkout the [configuration I'm using](https://github.com/8ctopus/sublime-text-config).

## credits

[neatcss](https://github.com/codazoda/neatcss)
