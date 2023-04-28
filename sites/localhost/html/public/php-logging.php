<?php

/**
 * Test php logging
 */

declare(strict_types=1);

namespace App;

use App\Page;

require_once '../autoload.php';

$page = new Page(true, true);

echo "<h1>test php logging</h1>\n";

error_log('test php logging');

// deprecated
define('CONSTANT', 'Hello world.');

echo "<pre>\n";

echo file_get_contents('/sites/localhost/logs/error_log');
