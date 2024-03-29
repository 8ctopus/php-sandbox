<?php

/**
 * Send http PSR-7 request using PSR-18 http client Shuttle
 */

declare(strict_types=1);

namespace App;

use App\Page;
use HttpSoft\Message\Request;
use HttpSoft\Message\RequestFactory;
use Nimbly\Shuttle\Shuttle;

require_once '../autoload.php';

$page = new Page(true, true);

echo <<<'BODY'
<h2>Client server communication using HTTP requests</h2>

BODY;

// create a http post request either directly or using a factory
// the advantage of using the factory is that it is standardized as PSR-17 and therefore you can change the implementation to a different package
$factory = true;

if ($factory) {
    $factory = new RequestFactory();

    $request = $factory->createRequest('POST', 'http://localhost/http-server.php');
} else {
    $request = new Request('POST', 'http://localhost/http-server.php');
}

// create PSR-18 http client
$shuttle = new Shuttle();

// send http post request to server
$response = $shuttle->sendRequest($request);

// process server response
echo <<<BODY
    <pre>
    status code: {$response->getStatusCode()}
    response body:
    {$response->getBody()->getContents()}

    BODY;
