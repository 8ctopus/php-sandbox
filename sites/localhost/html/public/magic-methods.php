<?php

/**
 * Test php magic methods
 *
 * @note https://www.php.net/manual/en/language.oop5.magic.php
 */

declare(strict_types=1);

class magic
{
    public function __call($method, $args) : void
    {
        echo "<p>You called method '{$method}' with argument {$args}.</p>\n";
        //var_dump($key, $args);
    }

    public function __invoke($arg) : void
    {
        echo "<p>You called method __invoke() with argument '{$arg}'.</p>\n";
    }
}

require_once '../header.php';

$a = new magic();

$a->test('hello', 'world');

$a(1);

require_once '../footer.php';
