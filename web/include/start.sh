#!/bin/sh

# start apache2
echo ""
echo "Start container web server..."
httpd -k start

echo "-----------------------------------------------"
echo "Start container web server - OK - Apache ready for connections"

stop_container()
{
    echo ""
    echo "Stop container web server... - received SIGTERM signal"

    # stop apache2
    echo "Stop apache2..."
    httpd -k stop

    echo "Stop container web server - OK"
    exit
}

# catch termination signals
# https://unix.stackexchange.com/questions/317492/list-of-kill-signals
trap stop_container SIGTERM

# infinite loop, will only stop on termination signal
while true; do
    sleep 5
    echo -n "."
done
