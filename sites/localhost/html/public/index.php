<?php

declare(strict_types=1);

require_once '../header.php';

$hostname = gethostname();

echo "<h1>Hello from {$hostname}!</h1>\n";
echo "<p>Browse the examples:</p>\n";
echo "<ul>\n";

// list current directory files
$it = new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS);

while ($it->valid()) {
    if (!$it->isDot()) {
        $file = $it->getSubPath() . '/' . $it->getSubPathName();

        switch ($it->getSubPathName()) {
            case 'ajax.php':
            case 'css':
            case 'favicon.ico':
            case 'index.php':
                break;

            default:
                echo "<li><a href=\"{$file}\">{$file}</a></li>\n";
                break;
        }
    }

    $it->next();
}

echo "</ul>\n";

require_once '../footer.php';
