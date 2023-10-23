<?php

/**
 * Floating point precision example
 * https://www.php.net/manual/en/language.types.float.php
 * https://floating-point-gui.de/
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

echo <<<'BODY'
<h2>Floating point precision</h2>
<pre>
BODY;

$number1 = 0.1;
$number2 = 0.7;

$expected = 0.8;
$total = $number1 + $number2;

if ($total === $expected) {
    echo "{$number1} + {$number2} === {$expected}\n";
} else {
    echo "{$number1} + {$number2} !== {$expected}\n";

    $difference = $expected - $total;
    echo "difference: {$difference}\n\n";
}

if (round($total, 3) === round($expected, 3)) {
    echo 'round($total, 3) === round($expected, 3)';
} else {
    echo 'round($total, 3) !== round($expected, 3)';
}
