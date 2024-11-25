<?php

declare(strict_types=1);

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    echo <<<'TXT'
    please run and refresh the page:

    docker exec -it sandbox zsh
    cd localhost/html
    composer install
    TXT;

    exit();
}

// include composer dependencies
require_once $autoLoad;
