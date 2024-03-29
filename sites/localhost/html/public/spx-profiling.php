<?php

/**
 * Test php spx
 */

declare(strict_types=1);

namespace App;

require_once '../autoload.php';

$page = new Page(true, true);

echo <<<'HTML'
<h1>php SPX profiler</h1>
<p><a href="/?SPX_KEY=dev&SPX_UI_URI=/" target="_blank">SPX control panel</a></p>
<pre>

HTML;

main();

function main() : void
{
    echo __METHOD__ . '... ' . delta_time() . PHP_EOL . PHP_EOL;

    slowme_100();
    slowme_200();
    slowme_400();

    echo __METHOD__ . ' - OK - ' . delta_time() . PHP_EOL;
}

function slowme_100() : void
{
    echo __METHOD__ . '... ' . delta_time() . PHP_EOL;

    usleep(100000);

    echo __METHOD__ . ' - OK - ' . delta_time() . PHP_EOL . PHP_EOL;
}

function slowme_200() : void
{
    echo __METHOD__ . '... ' . delta_time() . PHP_EOL;

    usleep(200000);

    echo __METHOD__ . ' - OK - ' . delta_time() . PHP_EOL . PHP_EOL;
}

function slowme_400() : void
{
    echo __METHOD__ . '... ' . delta_time() . PHP_EOL;

    usleep(400000);

    echo __METHOD__ . ' - OK - ' . delta_time() . PHP_EOL . PHP_EOL;
}

function delta_time() : int
{
    global $base;

    if (!isset($base)) {
        $base = hrtime(true);
        return 0;
    }

    return hrtime(true) - $base;
}
