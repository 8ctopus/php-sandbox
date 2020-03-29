# start container

    docker run -it -p 3306:3306 8ctopus/mariadb

# connect to database

    hostname: localhost
    user: root
    password: 123
    port: 3306

# build docker image

    docker build -t 8ctopus/mariadb:latest .
