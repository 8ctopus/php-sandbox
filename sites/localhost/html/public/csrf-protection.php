<?php

/**
 * cross site request forgery (CSRF) example
 *
 * A nice explanation can be found here https://www.phptutorial.net/php-tutorial/php-csrf/
 */

declare(strict_types=1);

namespace App;

use App\Page;
use Exception;

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    header('Content-type: text');

    echo <<<'TXT'
    please run and refresh the page:

    docker exec -it sandbox zsh
    cd localhost/html
    composer install
    TXT;

    exit();
}

// include composer dependencies
require_once $autoLoad;

// create whoops object
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        get();
        break;

    case 'POST':
        post();
        break;

    default:
        throw new Exception('unhandled method');
}

function get()
{
    $page = new Page(true);
    $page->body();

    session_start();

    $csrf = bin2hex(random_bytes(10));

    $_SESSION['csrf'] = $csrf;

    $users = $_SESSION['users'] ?? [];
    $usersHtml = '';

    if (count($users)) {
        foreach ($users as $user) {
            $usersHtml .= "<li>{$user}</li>\n";
        }
    }

    echo <<<HTML
    <h1> CSRF example </h1>
    <form action="" method="post">
        <input type="hidden" name="csrf" id="csrf" value="{$csrf}" />
        <label for="name">Enter your name: </label>
        <input type="text" name="name" id="name" required />
        <input type="submit" value="Add" />
    </form>
    <div>
        <p> Existing users </p>
        <ul>
        {$usersHtml}
        </ul>
    </div>
    HTML;
}

function post()
{
    $csrf = $_POST['csrf'] ?? null;

    session_start();

    if ($csrf === null || $csrf !== $_SESSION['csrf']) {
        // attacker doesn't have the csrf token because the html page content is inaccessible to him
        http_response_code(401);
        return;
    }

    // csrf token matches, we use the data sent
    $_SESSION['users'][] = $_POST['name'];
    unset($_SESSION['csrf']);
    http_response_code(200);
    header('refresh: 0;');
}
