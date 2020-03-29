# start mariadb service
rc-service mariadb start;

# configure database
mysql < /init.sql;

# start zsh
zsh;