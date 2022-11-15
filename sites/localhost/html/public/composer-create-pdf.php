<?php

/**
 * Simple example that shows how to use composer
 * In this case we include [Dompdf](https://github.com/dompdf/dompdf) which is a PDF generator
 */

use Dompdf\Dompdf;

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    header('Content-type: text');

    echo <<<TXT
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
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// create pdf engine
$dompdf = new Dompdf();

$dompdf->setPaper('A4', 'portrait');

$dompdf->loadHtml('<h1>hello from Docker container!</h1>');

// render html as pdf
$dompdf->render();

// output pdf to browser
$dompdf->stream('hello.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
