<?php

/**
 * Test php logging
 */

declare(strict_types=1);

require_once '../header.php';

echo "<h1>test php logging</h1>\n";

error_log('test php logging');

// deprecated
define("CONSTANT", "Hello world.", true);

echo "<pre>\n";

echo file_get_contents('/var/log/apache2/error_log');
