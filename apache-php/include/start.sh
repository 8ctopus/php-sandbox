#!/bin/sh

echo ""
echo "Start container web server..."

# check if we should expose /etc/apache2/ to host
if [ -d /docker/etc/ ];
then
    echo "Expose /etc/apache2/ to host..."
    sleep 3

    # check if directory empty
    if [ -z "$(ls -A /docker/etc/apache2)" ];
    then
        echo "Expose /etc/apache2/ to host - copy files..."
        cp -r /etc/apache2/ /docker/etc/
        rm -rf /etc/apache2/
        ln -s /docker/etc/apache2 /etc/apache2
    else
        echo "Expose /etc/apache2/ to host - config exists on host"
    fi

    echo "Expose /etc/apache2/ to host - OK"

    echo "Expose /etc/php7/ to host..."
    sleep 3

    # check if directory empty
    if [ -z "$(ls -A /docker/etc/php7)" ];
    then
        echo "Expose /etc/php7/ to host - copy files..."
        cp -r /etc/php7/ /docker/etc/
        rm -rf /etc/php7/
        ln -s /docker/etc/php7 /etc/php7
    else
        echo "Expose /etc/php7/ to host - config exists on host"
    fi

    echo "Expose /etc/php7/ to host - OK"
fi

echo "-----------------------------------------------"

# start apache2
httpd -k start

# check if apache2 is running
if pgrep -x httpd > /dev/null
then
    echo "Start container web server - OK - ready for connections"
else
    echo "Start container web server - OK - FAILED"
    exit
fi

stop_container()
{
    echo ""
    echo "Stop container web server... - received SIGTERM signal"

    # stop apache2
    echo "Stop apache2..."
    httpd -k stop
    echo "Stop apache2 - OK"

    echo "Stop container web server - OK"
    exit
}

# catch termination signals
# https://unix.stackexchange.com/questions/317492/list-of-kill-signals
trap stop_container SIGTERM

restart_apache2()
{
    sleep 0.5

    # test apache2 config
    if httpd -t
    then
        # restart apache2
        echo "Restart apache2..."
        httpd -k restart

        # check if apache2 is running
        if pgrep -x httpd > /dev/null
        then
            echo "Restart apache2 - OK"
        else
            echo "Restart apache2 - FAILED"
        fi
    else
        echo "Restart apache2 - FAILED - syntax error"
    fi
}

# infinite loop, will only stop on termination signal
while true; do
    # restart apache if any file in /etc/apache2 changes
    inotifywait --quiet --event modify,create,delete --recursive /etc/apache2/ && restart_apache2

    sleep 2
    echo -n "."
done
