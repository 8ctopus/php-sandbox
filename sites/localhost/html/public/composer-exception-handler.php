<?php

/**
 * Simple example that shows how to use composer
 * In this case we include [Whoops](https://github.com/filp/whoops) which is a php error handler
 */

declare(strict_types=1);

namespace App;

use App\Page;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

require_once '../autoload.php';

$page = new Page(true, true);

// create whoops object
$whoops = new Whoops();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

// let's generate a division by zero to showcase what whoops does
$a = 1;
$b = 0;

$c = $a / $b;
