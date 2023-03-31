<?php

/**
 * Test database connection
 */

declare(strict_types=1);

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    header('Content-type: text');

    echo <<<'TXT'
        please run and refresh the page:

        docker exec -it sandbox zsh
        cd localhost/html
        composer install
    TXT;

    exit;
}

// include composer dependencies
require_once $autoLoad;

// create whoops object
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
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

$sql = <<<'SQL'
    DROP TABLE IF EXISTS test
SQL;

$query = $db->prepare($sql);
$query->execute();

$sql = <<<'SQL'
    CREATE TABLE test (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `birthday` DATE NOT NULL,
        `name` VARCHAR(40) NOT NULL,
        `salary` INT NOT NULL,
        `boss` BIT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;

$query = $db->prepare($sql);
$query->execute();

$sql = <<<'SQL'
    INSERT INTO test
    (birthday, name, salary, boss)
    VALUES (:birthday, :name, :salary, :boss)
SQL;

$query = $db->prepare($sql);

$staff = [
    [
        'birthday' => (new DateTime('1995-05-01'))->format('Y-m-d'),
        'name' => 'Sharon',
        'salary' => '200',
        'boss' => true,
    ],
    [
        'birthday' => (new DateTime('2000-01-01'))->format('Y-m-d'),
        'name' => 'John',
        'salary' => '140',
        'boss' => false,
    ],
    [
        'birthday' => (new DateTime('1985-08-01'))->format('Y-m-d'),
        'name' => 'Oliver',
        'salary' => '120',
        'boss' => false,
    ],
];


foreach ($staff as $member) {
    bindValues($query, $member)->execute();
}

$sql = <<<'SQL'
    SELECT *
    FROM test
SQL;

$query = $db->prepare($sql);
$query->execute();

while ($row = $query->fetch()) {
    echo "<li>{$row['id']} {$row['birthday']} {$row['name']} {$row['salary']} {$row['boss']}</li>\n";
}

echo "</ul>\n";
echo "<h1>Test database - OK!<h1>\n";

require_once '../footer.php';

/**
 * Bind values to PDO statement
 *
 * @param PDOStatement $statement
 * @param array        $data
 *
 * @return PDOStatement
 */
function bindValues(PDOStatement $statement, array $data) : PDOStatement
{
    foreach ($data as $key => $value) {
        $statement->bindValue($key, $value, typeToParam($value));
    }

    return $statement;
}

/**
 * Variable to PDO type
 *
 * @param mixed $value
 *
 * @return int PDO type
 */
function typeToParam(mixed $value) : int
{
    switch ($type = gettype($value)) {
        case 'boolean':
            return PDO::PARAM_BOOL;

        case 'integer':
            return PDO::PARAM_INT;

        case 'NULL':
            return PDO::PARAM_NULL;

        case 'string':
            return PDO::PARAM_STR;

        default:
            throw new Exception("unsupported type - {$type}");
    }
}
