<?php

/**
 * Test xdebug
 */

declare(strict_types=1);

require_once '../header.php';

echo '<h1>Test Xdebug</h1>';

echo "<p>REMOTE ADDR: {$_SERVER['REMOTE_ADDR']}</p>\n";

class Strings
{
    public static function fix_string($a) : void
    {
        echo xdebug_call_class(0) . '::' . xdebug_call_function(0) . ' is called at ' . xdebug_call_file(0) . ':' . xdebug_call_line(0);
    }

    public static function fix_strings(array $a) : void
    {
        foreach ($a as $element) {
            self::fix_string($a);
        }
    }
}

$ret = Strings::fix_strings(['Derick']);

require_once '../footer.php';
