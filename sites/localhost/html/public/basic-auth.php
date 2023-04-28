<?php

/**
 * Test http basic authentication
 */

declare(strict_types=1);

if (!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic');
    exit;
}

require_once '../templates.php';

Templates::head();
Templates::body();

echo '<p>You\'re authorized.</p>';

Templates::footer();
