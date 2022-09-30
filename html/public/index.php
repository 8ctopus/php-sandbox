<?php

require_once '../header.php';

echo "<h1>Hello from docker container</h1>\n";
echo "<p>Browse the examples:</p>\n";
echo "<ul>\n";

// list current directory files
$it = new RecursiveDirectoryIterator(__DIR__, FilesystemIterator::SKIP_DOTS);

while ($it->valid()) {
    if (!$it->isDot()) {
        $file = $it->getSubPath() .'/'. $it->getSubPathName();

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
