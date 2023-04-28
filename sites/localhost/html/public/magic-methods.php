<?php

/**
 * Test php magic methods
 *
 * @note https://www.php.net/manual/en/language.oop5.magic.php
 */

declare(strict_types=1);

require_once '../templates.php';

Templates::head();
Templates::body();

$a = new Magic();

$a->test('hello', 'world');

$a(1);

Templates::footer();

class Magic
{
    public function __call($method, $args) : void
    {
        $args = implode(', ', $args);

        echo "<p>You called method '{$method}' with arguments {$args}.</p>\n";
        //var_dump($key, $args);
    }

    public function __invoke($arg) : void
    {
        echo "<p>You called method '__invoke()' with argument '{$arg}'.</p>\n";
    }
}
