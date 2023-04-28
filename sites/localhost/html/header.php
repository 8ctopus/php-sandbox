<?php

declare(strict_types=1);

use SebastianBergmann\Timer\Timer;

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
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

$timer = new Timer;
$timer->start();

?><html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/neat.css" rel="stylesheet">
</head>
<body>
    <a class="home" href="/">Back home</a>
