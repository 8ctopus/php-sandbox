#!/bin/sh

echo ""
echo "Start container web server..."

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

# infinite loop, will only stop on termination signal
while true; do
    sleep 3
    echo -n "."
done
