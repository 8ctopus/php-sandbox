<?php

/**
 * Test http basic authentication
 */

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    require_once '../header.php';
    echo '<p>You\'re authorized.</p>';
}
else {
    header('WWW-Authenticate: Basic');
}
