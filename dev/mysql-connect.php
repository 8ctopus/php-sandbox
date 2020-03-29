<?php

$mysqli = new mysqli('dev-db', 'root', '123', 'test');

if ($mysqli->connect_errno)
{
    echo('Sorry, this website is experiencing problems.');
    echo('Error: Failed to make a MySQL connection, here is why: \n');
    echo('Errno: " . $mysqli->connect_errno . "\n');
    echo('Error: " . $mysqli->connect_error . "\n');
    exit();
}

$sql = <<<TAG
    CREATE TABLE IF NOT EXISTS `test` (
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    );
TAG;

if (!$result = $mysqli->query($sql))
{
    echo('Sorry, the website is experiencing problems.');
    echo('Error: Our query failed to execute and here is why: \n');
    echo('Query: " . $sql . "\n');
    echo('Errno: " . $mysqli->errno . "\n');
    echo('Error: " . $mysqli->error . "\n');
    exit();
}

$sql = "SHOW TABLES";

if (!$result = $mysqli->query($sql))
{
    echo('Sorry, the website is experiencing problems.');
    echo('Error: Our query failed to execute and here is why: \n');
    echo('Query: " . $sql . "\n');
    echo('Errno: " . $mysqli->errno . "\n');
    echo('Error: " . $mysqli->error . "\n');
    exit();
}

if ($result->num_rows === 0)
{
    echo('Sorry, the website is experiencing problems.');
    echo('Error: Our query failed to execute and here is why: \n');
    echo('test database has no tables');
    exit();
}

echo('<pre>');
print_r($result->fetch_assoc());
