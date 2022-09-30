<?php

/**
 * Test database connection
 */

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    echo 'please run "docker exec sandbox composer install" and refresh the page';
    exit;
}

// include composer dependencies
require_once $autoLoad;

// create whoops object
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

require_once '../header.php';

echo "<h1>Test database...</h1>\n";

$params = [
    'host' => 'sandbox-db',
    'database' => 'test',
    'user' => 'root',
    'pass' => '123',
];

$db = new PDO("mysql:host={$params['host']};dbname={$params['database']};charset=utf8", $params['user'], $params['pass'], [
    // use exceptions
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // get arrays
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // better prevention against SQL injections
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$sql = <<<SQL
    CREATE TABLE IF NOT EXISTS `test` (
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
SQL;

$query = $db->prepare($sql);
$query->execute();

$sql = <<<SQL
    CREATE TABLE IF NOT EXISTS `test2` (
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
SQL;

$query = $db->prepare($sql);
$query->execute();

$sql = <<<SQL
    SHOW TABLES;
SQL;

$query = $db->prepare($sql);
$query->execute();

if ($query->rowCount() === 0) {
    throw new Exception('database has no tables');
}

echo "<p>Database has {$query->rowCount()} tables</p>\n";
echo "<ul>\n";

while ($row = $query->fetch()) {
    echo "<li>{$row['Tables_in_test']}</li>\n";
}

echo "</ul>\n";
echo "<h1>Test database - OK!<h1>\n";

require_once '../footer.php';
