<?php

/**
 * Send http PSR-7 request using PSR-18 http client Shuttle
 */

declare(strict_types=1);

use HttpSoft\Message\Request;
use Nimbly\Shuttle\Shuttle;

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

require $autoLoad;

require_once '../header.php';

echo
    <<<BODY
    <h2>Client server communication using HTTP requests</h2>

    BODY;

// create a http post request
$request = new Request('POST', 'http://localhost/http-server.php');

// create PSR-18 http client
$shuttle = new Shuttle();

// send http post request to server
$response = $shuttle->sendRequest($request);

// process server response
echo
    <<<BODY
    <pre>
    status code: {$response->getStatusCode()}
    response body:
    {$response->getBody()->getContents()}

    BODY;
