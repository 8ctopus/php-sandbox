<?php

/**
 * Test http basic authentication
 */

declare(strict_types=1);

if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic');
    exit;
}

require_once '../autoload.php';

$page = new Page(true, true);




echo '<p>You\'re authorized.</p>';
