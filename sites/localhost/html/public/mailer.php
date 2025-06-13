<?php

declare(strict_types=1);

namespace App;

use App\Page;
use Exception;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

require_once '../autoload.php';

$page = new Page(true, true);

// create whoops object
$whoops = new Whoops();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

$email = 'hello@octopuslabs.io';

/*
$server = 'mail.octopuslabs.io';
$pass = '';

if (empty($pass)) {
    throw new Exception('password missing');
}

$transport = Transport::fromDsn("smtp://{$email}:{$pass}@{$server}:25");
*/

$transport = Transport::fromDsn("sendmail://default");

$mailer = new Mailer($transport);

$email = (new Email())
    ->from($email)
    ->to($email)
    ->subject('Time for Symfony Mailer!')
    ->text('Sending emails is fun again!')
    ->html('<p>See Twig integration for better HTML integration!</p>');

$mailer->send($email);

?>
<p> email sent </p>
<a href="localhost:8025">check mailpit</a>
