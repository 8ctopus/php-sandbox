# check if database exists
if [ -e /var/lib/mysql/ib_logfile0 ]
then
    echo "Database already exists"

    # start service mariadb
    echo "Start service mariadb..."
    rc-service mariadb restart

    echo "-----------------------------------------------"
    echo "Database ready for connections"
else
    # create database
    echo "Install database..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql

    # start service mariadb
    echo "Install database - start service mariadb..."
    rc-service mariadb start

    # configure database
    echo "Install database - configure users..."
    mysql < /init.sql

    echo "Install database - OK"

    echo "-----------------------------------------------"
    echo "Database ready for connections"
    echo "host: localhost"
    echo "port: 3306"
    echo "user: root"
    echo "password: 123"
fi

# wait forever
tail -f /dev/null
