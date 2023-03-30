<?php

/**
 * Test http basic authentication
 */

declare(strict_types=1);

if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    require_once '../header.php';
    echo '<p>You\'re authorized.</p>';
} else {
    header('WWW-Authenticate: Basic');
}
