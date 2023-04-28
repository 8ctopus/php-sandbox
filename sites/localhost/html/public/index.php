<?php

declare(strict_types=1);

require_once '../templates.php';

Templates::head();
Templates::body();

$hostname = gethostname();

echo <<<BODY
<h1>Hello from {$hostname}!</h1>
<p>Browse the examples:</p>
<ul>

BODY;

// list current directory files
$it = new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS);

while ($it->valid()) {
    if (!$it->isDot()) {
        $file = $it->getSubPath() . '/' . $it->getSubPathName();

        switch ($it->getSubPathName()) {
            case 'ajax-request.php':
            case 'css':
            case 'favicon.ico':
            case 'index.php':
            case 'http-server.php':
                break;

            default:
                echo "<li><a href=\"{$file}\">{$file}</a></li>\n";
                break;
        }
    }

    $it->next();
}

echo "</ul>\n";

Templates::footer();
