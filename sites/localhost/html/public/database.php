<?php

declare(strict_types=1);

namespace App;

use App\Page;
use DateTime;
use Nette\Database\Connection;
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

$database = new Connection("mysql:host={$params['host']};dbname={$params['database']};charset=utf8", $params['user'], $params['pass']);

$database->query('DROP TABLE IF EXISTS test');

$sql = <<<'SQL'
CREATE TABLE test (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `birthday` DATE NOT NULL,
    `name` VARCHAR(40) NOT NULL,
    `salary` INT NOT NULL,
    `boss` BIT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;

$database->query($sql);

$staff = [
    [
        'birthday' => new DateTime('1995-05-01'),
        'name' => 'Sharon',
        'salary' => '200',
        'boss' => true,
    ],
    [
        'birthday' => new DateTime('2000-01-01'),
        'name' => 'John',
        'salary' => '140',
        'boss' => false,
    ],
    [
        'birthday' => new DateTime('1985-08-01'),
        'name' => 'Oliver',
        'salary' => '120',
        'boss' => false,
    ],
];

/*
for ($i = 0; $i < 12; ++$i) {
    $staff = array_merge($staff, $staff);
}

echo count($staff);
*/

//\spx_profiler_start();

$database->query('INSERT INTO test', $staff);

//\spx_profiler_stop();

$rows = $database->query('SELECT * FROM test');

echo "<ul>\n";

foreach ($rows as $row) {
    echo "<li>{$row['id']} {$row['birthday']} {$row['name']} {$row['salary']} {$row['boss']}</li>\n";
}

echo "</ul>\n";
echo "<ul>\n";

$sql = <<<'SQL'
SELECT
    *
FROM
    test
WHERE
    name IS NOT NULL AND
    ?and
ORDER BY
    ?order
SQL;

$rows = $database->query($sql, [
    'id <' => 10,
    'salary >' => 120,
], [
    'id' => false,
]);

foreach ($rows as $row) {
    echo "<li>{$row['id']} {$row['birthday']} {$row['name']} {$row['salary']} {$row['boss']}</li>\n";
}

echo <<<'HTML'
</ul>
<h1>Test database - OK!</h1>

HTML;
