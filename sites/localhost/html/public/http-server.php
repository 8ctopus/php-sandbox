<?php

/**
 * Server side response to http request
 */

declare(strict_types=1);

use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\Message\Response;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\ServerRequest\ServerRequestCreator;

require_once '../autoload.php';

// read request from client
$request = ServerRequestCreator::createFromGlobals($_SERVER, $_FILES, $_COOKIE, $_GET, $_POST);

// create response either directly or using a factory
// the advantage of using the factory is that it is standardized as PSR-17 and therefore you can change the implementation to a different package
$factory = true;

if ($factory) {
    $factory = new ResponseFactory();

    $response = $factory->createResponse(200);
} else {
    $response = new Response(200);
}

// create response body
$body = <<<BODY
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
