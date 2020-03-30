# start apache2
echo ""
echo "Start container web server..."
httpd -k start

echo "-----------------------------------------------"
echo "Start container web server - OK - Apache ready for connections"

stop_container()
{
    echo ""
    echo "Stop container web server... - received termination signal"

    # stop apache2
    echo "Stop apache2..."
    httpd -k stop

    echo "Stop container web server - OK"
    exit
}

# catch termination signals
trap stop_container INT SIGINT SIGQUIT SIGTERM SIGABRT

# infinite loop, will only stop on termination signal
while true; do
    sleep 5
    echo -n "."
done
