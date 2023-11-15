<?php

/**
 * Ajax example (Asynchronous JavaScript and XML)
 */

declare(strict_types=1);

namespace App;

use App\Page;

require_once '../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ajax request
    echo 'in ajax!';
    return;
}

$page = new Page(true);

echo <<<'HTML'
<script type="text/javascript">

// wait for html to be loaded
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(ajax, 2000);
});

async function ajax()
{
    const response = await fetch('/ajax.php', {
      method: 'POST',
    });

    let text;

    if (response.ok) {
        text = await response.text();
    } else {
        text = 'ajax error';
    }

    // update textarea text
    const output = document.querySelector('textarea');

    output.innerHTML += text;
}

</script>

HTML;

$page->body();

echo <<<'HTML'
<h1> Ajax example </h1>
<div>
    <textarea rows=10 cols=50>hello world </textarea>
</div>
HTML;
