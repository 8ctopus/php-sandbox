<?php

declare(strict_types=1);

namespace App;

use SebastianBergmann\Timer\Timer;
use SebastianBergmann\Timer\ResourceUsageFormatter;

class Page
{
    private bool $header;
    private bool $body;
    private bool $footer;
    private Timer $timer;

    public function __construct(bool $header = false, bool $body = false)
    {
        $this->header = false;
        $this->body = false;
        $this->footer = false;

        $this->timer = new Timer();
        $this->timer->start();

        if ($header) {
            $this->header();
        }

        if ($body) {
            $this->body();
        }
    }

    public function __destruct()
    {
        $this->footer();
    }

    public function header() : self
    {
        if ($this->header) {
            return $this;
        }

        $this->header = true;

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <link href="https://cdn.jsdelivr.net/gh/codazoda/neatcss@v1.0.12/neat.css" rel="stylesheet" crossorigin="anonymous" integrity="d5aba09c5ea7ca3260a07edbb3acf62813e607b8c0f01d2580fc1c57103bb643">
        <style>

        :root {
          border-top: none;
        }

        </style>

        HTML;

        return $this;
    }

    public function body(string $content = '') : self
    {
        if ($this->body) {
            return $this;
        }

        $this->body = true;

        $content = ($_SERVER['REQUEST_URI'] ?? '') !== '/' ? '<a class="home" href="/">Back home</a>' : '';

        echo <<<HTML
        </head>
        <body>
            <br>
            {$content}

        HTML;

        return $this;
    }

    public function footer() : self
    {
        if ($this->footer) {
            return $this;
        }

        $this->footer = true;

        $elapsed = (new ResourceUsageFormatter)->resourceUsageSinceStartOfRequest();

        echo <<<HTML
            </pre>
            <p> {$elapsed} </p>
            </div>
            </body>
            </html>

        HTML;

        return $this;
    }
}
