<?php

/**
 * Test xdebug
 */

declare(strict_types=1);

require_once '../header.php';

echo <<<HTML
<h1>Test Xdebug</h1>
<p>REMOTE ADDR: {$_SERVER['REMOTE_ADDR']}</p>
<pre>

HTML;

$strings = new XDebugTest();

$strings->test(['Derick', 'Rehans']);

require_once '../footer.php';

class XDebugTest
{
    public function test(array $a) : void
    {
        foreach ($a as $element) {
            $this->item($element);
        }
    }

    protected function item(string $element) : void
    {
        echo $element . ' ' . xdebug_call_class(0) . '::' . xdebug_call_function(0) . ' is called at ' . xdebug_call_file(0) . ':' . xdebug_call_line(0) . PHP_EOL;
    }
}
