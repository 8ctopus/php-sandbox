<?php

/**
 * Test php magic methods
 * @note https://www.php.net/manual/en/language.oop5.magic.php
 */

class magic
{
    public function __call($method, $args)
    {
        echo "<p>You called method '{$method}' with argument {$args}.</p>\n";
        //var_dump($key, $args);
    }

    public function __invoke($arg)
    {
        echo "<p>You called method __invoke() with argument '{$arg}'.</p>\n";
    }
}

require_once '../header.php';

$a = new magic();

$a->test('hello', 'world');

$a(1);

