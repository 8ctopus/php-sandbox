<?php

/**
 * Ajax example (Asynchronous JavaScript and XML)
 */

declare(strict_types=1);

require_once '../templates.php';

head();

echo <<<HTML
<script type="text/javascript">

// wait for html to be loaded
document.addEventListener("DOMContentLoaded", async () => {
    // get textarea element
    const output = document.querySelector("textarea");

    // http get request
    const response = await fetch("/ajax-request.php");

    let text;

    if (response.ok) {
        text = await response.text();
    } else {
        text = "ajax error";
    }

    // update text
    output.innerHTML += text;
});

</script>

HTML;

body();

echo <<<HTML
    <div>
        <textarea rows=10 cols=50>hello world</textarea>
    </div>
HTML;

footer();
