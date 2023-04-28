<?php

declare(strict_types=1);

//use SebastianBergmann\Timer\Timer;
use SebastianBergmann\Timer\ResourceUsageFormatter;

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

//$timer = new Timer;
//$timer->start();

function head() : void
{
    echo <<<HTML
    <html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/neat.css" rel="stylesheet">

    HTML;
}

function body() : void
{
    echo <<<HTML
    </head>
    <body>
        <a class="home" href="/">Back home</a>

    HTML;
}

function footer() : void
{
    $elapsed = (new ResourceUsageFormatter)->resourceUsageSinceStartOfRequest();

    echo <<<HTML
        </pre>
        <p> {$elapsed} </p>
        </div>
        </body>
        </html>

    HTML;
}
