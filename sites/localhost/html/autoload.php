<?php

declare(strict_types=1);

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    echo <<<'HTML'
    <pre>
    please run and refresh the page:

    docker exec -it sandbox zsh
    cd localhost/html
    composer install
    </pre>
    HTML;

    exit();
}

// include composer dependencies
require_once $autoLoad;
