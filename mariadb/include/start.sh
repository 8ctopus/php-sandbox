#!/bin/sh

echo "..."
echo "Start container database..."

# check if we should expose /etc/my.cnf.d/ to host
if [ -d /docker/etc/ ];
then
    echo "Expose /etc/my.cnf.d/ to host..."
    sleep 3

    # check if directory exists
    if [ ! -d /docker/etc/my.cnf.d/ ];
    then
        echo "Expose /etc/my.cnf.d/ to host - copy files..."
        cp -r /etc/my.cnf.d/ /docker/etc/
        rm -rf /etc/my.cnf.d/
        ln -s /docker/etc/my.cnf.d /etc/my.cnf.d
    else
        echo "Expose /etc/my.cnf.d/ to host - config exists on host"
        rm -rf /etc/my.cnf.d/
        ln -s /docker/etc/my.cnf.d /etc/my.cnf.d
    fi

    echo "Expose /etc/my.cnf.d/ to host - OK"
fi

# check if database exists
if [ -e /var/lib/mysql/ib_logfile0 ]
then
    echo "Database exists"

    # start service mariadb
    echo "Start service mariadb..."
    rc-service mariadb restart
else
    # create database
    echo "Install database..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql

    # start service mariadb
    echo "Install database - start service mariadb..."
    rc-service mariadb start

    # check if mariadb is running
    if pgrep -x /usr/bin/mysqld > /dev/null
    then
        # configure database
        echo "Install database - configure users..."
        mysql < /init.sql

        echo "Install database - OK"
    else
        echo "Install database - FAILED"
    fi
fi

echo "-----------------------------------------------"

# check if mariadb is running
if pgrep -x /usr/bin/mysqld > /dev/null
then
    echo "host: localhost"
    echo "port: 3306"
    echo "user: root"
    echo "password: 123"
    echo "-----------------------------------------------"
    echo "Start container database - OK - ready for connections"
else
    echo "Start container database - FAILED"
    exit
fi

# https://www.ctl.io/developers/blog/post/gracefully-stopping-docker-containers/
# https://stackoverflow.com/questions/59521712/catching-sigterm-from-alpine-image
stop_container()
{
    echo ""
    echo "Stop container database... - received SIGTERM signal"
    echo "Stop service mariadb ..."
    rc-service mariadb stop
    echo "Stop service mariadb - OK"
    echo "Stop container database - OK"
    exit
}

# wait for termination signal
trap stop_container SIGTERM

restart_mariadb()
{
    sleep 0.5

    # test mariadb config
    if ! mysqld --help 2>&1 | grep -ci error
    then
        # restart mariadb
        echo "Restart mariadb..."
        rc-service mariadb restart

        # check if mariadb is running
        if pgrep -x /usr/bin/mysqld > /dev/null
        then
            echo "Restart mariadb - OK"
        else
            echo "Restart mariadb - FAILED"
        fi
    else
        echo "Restart mariadb - FAILED - syntax error"
    fi
}

while true; do
    # restart mariadb if any file in /etc/my.cnf.d changes
    inotifywait --quiet --event modify,create,delete --recursive /etc/my.cnf.d/ && restart_mariadb

    sleep 2
    echo -n "."
done
