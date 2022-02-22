<?php

/**
 * Test database connection
 * based on https://www.php.net/manual/en/mysqli.examples-basic.php
 */

require_once '../header.php';

$mysqli = new mysqli("sandbox-db", "root", "123", "test");

if ($mysqli->connect_errno) {
    echo "Sorry, this website is experiencing problems.\n";
    echo "Error: Failed to make a MySQL connection, here is why:\n";
    echo "Errno.". $mysqli->connect_errno ."\n";
    echo "Error.". $mysqli->connect_error ."\n";
    exit();
}

$sql = <<<TAG
    CREATE TABLE IF NOT EXISTS `test` (
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    );
TAG;

if (!$result = $mysqli->query($sql)) {
    echo "Sorry, the website is experiencing problems.\n";
    echo "Error: Our query failed to execute and here is why:\n";
    echo "Query.". $sql ."\n";
    echo "Errno.". $mysqli->errno ."\n";
    echo "Error.". $mysqli->error ."\n";
    exit();
}

$sql = <<<TAG
    SHOW TABLES;
TAG;

if (!$result = $mysqli->query($sql)) {
    echo "Sorry, the website is experiencing problems.\n";
    echo "Error: Our query failed to execute and here is why:\n";
    echo "Query.". $sql ."\n";
    echo "Errno.". $mysqli->errno ."\n";
    echo "Error.". $mysqli->error ."\n";
    exit();
}

if ($result->num_rows === 0) {
    echo "Sorry, the website is experiencing problems.\n";
    echo "Error: Our query failed to execute and here is why:\n";
    echo "test database has no tables\n";
    exit();
}

print_r($result->fetch_assoc());

echo "<h1>It works!<h1>\n";

require_once '../footer.php';
