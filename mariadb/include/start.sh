# check if database exists
if [ -e /var/lib/mysql/ib_logfile0 ]
then
    echo "Database already exists"

    # start mariadb service
    echo "Start mariadb service..."
    rc-service mariadb restart
else
    # create database
    echo "Install database..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql

    # start mariadb service
    echo "Install database - start mariadb service..."
    rc-service mariadb start

    # configure database
    echo "Install database - configure users..."
    mysql < /init.sql

    echo "Install database - OK"
    echo "-----------------------------------------------"
    echo "Database info"
    echo "host: localhost"
    echo "port: 3306"
    echo "user: root"
    echo "password: 123"
fi

# wait forever
tail -f /dev/null
