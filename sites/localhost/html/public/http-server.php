<?php

/**
 * Server side response to http request
 */

declare(strict_types=1);

use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\ServerRequest\ServerRequestCreator;
use HttpSoft\Message\Response;
use HttpSoft\Message\ResponseFactory;

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

// read request from client
$request = ServerRequestCreator::createFromGlobals($_SERVER, $_FILES, $_COOKIE, $_GET, $_POST);

// create response either directly or using a factory
$factory = true;

if ($factory) {
    $factory = new ResponseFactory();

    $response = $factory->createResponse(200);
} else {
    $response = new Response(200);
}

// create response body
$body =
    <<<BODY
    Hello world!
    request target: {$request->getRequestTarget()}
    request method: {$request->getMethod()}

    BODY;

$response
    ->getBody()
    ->write($body);

// send response to client (internally echoes)
$emitter = new SapiEmitter();

$emitter->emit($response);
