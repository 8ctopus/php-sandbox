<?php

/**
 * Floating point precision example
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
<p>
    Interesting articles about floating point precision
    <ul>
        <li> https://www.php.net/manual/en/language.types.float.php </li>
        <li> https://floating-point-gui.de/ </li>
    </ul>
</p>
<pre>
BODY;

$items = [
    [
        'number1' => 0.1,
        'number2' => 0.3,
        'expected' => 0.4,
    ],
    [
        'number1' => 0.1,
        'number2' => 0.7,
        'expected' => 0.8,
    ],
];

foreach ($items as $item) {
    $number1 = $item['number1'];
    $number2 = $item['number2'];
    $expected = $item['expected'];

    $total = $number1 + $number2;

    if ($total === $expected) {
        echo "{$number1} + {$number2} === {$expected}\n\n";
    } else {
        echo "{$number1} + {$number2} !== {$expected}\n";

        $difference = $expected - $total;
        echo "difference: {$difference}\n";

        if (round($total, 3) === round($expected, 3)) {
            echo "round(\$total, 3) === round(\$expected, 3)\n";
        } else {
            echo "round(\$total, 3) !== round(\$expected, 3)\n";
        }
    }
}
