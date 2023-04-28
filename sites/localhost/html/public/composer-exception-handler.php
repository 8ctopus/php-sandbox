<?php

/**
 * Simple example that shows how to use composer
 * In this case we include [Whoops](https://github.com/filp/whoops) which is a php error handler
 */

declare(strict_types=1);

require_once '../header.php';

// create whoops object
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

// let's generate a division by zero to showcase what whoops does
$a = 1;
$b = 0;

$c = $a / $b;

require_once '../footer.php';
