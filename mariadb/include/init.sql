USE `mysql`;

# create user root with access from any host
CREATE USER 'root'@'%' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;
