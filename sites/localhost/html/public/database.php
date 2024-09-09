<?php

declare(strict_types=1);

namespace App;

use App\Page;
use DateTime;
use PDO;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

require_once '../autoload.php';

$page = new Page(true, true);

// create whoops object
$whoops = new Whoops();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

echo "<h1>Test database...</h1>\n";

$params = [
    'host' => 'sandbox-db',
    'database' => 'test',
    'user' => 'root',
    'pass' => '123',
];

$pdo = new PDO("mysql:host={$params['host']};dbname={$params['database']};charset=utf8", $params['user'], $params['pass']);

$pdo->exec('DROP TABLE IF EXISTS `test`');

$sql = <<<'SQL'
CREATE TABLE `test` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `birthday` DATE NOT NULL,
    `name` VARCHAR(40) NOT NULL,
    `salary` INT NOT NULL,
    `boss` BOOL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
SQL;

$pdo->exec($sql);

$staff = [
    [
        'birthday' => new DateTime('1995-05-01'),
        'name' => 'Sharon',
        'salary' => 200,
        'boss' => true,
    ],
    [
        'birthday' => new DateTime('2000-01-01'),
        'name' => 'John',
        'salary' => 140,
        'boss' => false,
    ],
    [
        'birthday' => new DateTime('1985-08-01'),
        'name' => 'Oliver',
        'salary' => 120,
        'boss' => false,
    ],
];

$sql = <<<SQL
INSERT INTO `test`
    (`birthday`, `name`, `salary`, `boss`)
VALUES
    (:birthday, :name, :salary, :boss)
SQL;

$query = $pdo->prepare($sql);

foreach ($staff as $employee) {
    $query->execute([
        'birthday' => $employee['birthday']->format('Y-m-d'),
        'name' => $employee['name'],
        'salary' => $employee['salary'],
        'boss' => $employee['boss'] ? 1 : 0,
    ]);
}

$query = $pdo->prepare('SELECT * FROM `test`');
$query->execute();

$rows = $query->fetchAll();

echo "<ul>\n";

foreach ($rows as $row) {
    echo "<li>{$row['id']} {$row['birthday']} {$row['name']} {$row['salary']} {$row['boss']}</li>\n";
}

echo "</ul>\n";

echo <<<'HTML'
</ul>
<h1>Test database - OK!</h1>

HTML;
