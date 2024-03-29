<?php

declare(strict_types=1);

namespace App;

use App\Page;
use Exception;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
$server = 'mail.octopuslabs.io';
$pass = '';

if (empty($pass)) {
    throw new Exception('password missing');
}

$transport = Transport::fromDsn("smtp://{$email}:{$pass}@{$server}:25");

$mailer = new Mailer($transport);

$email = (new Email())
    ->from($email)
    ->to($email)
    ->subject('Time for Symfony Mailer!')
    ->text('Sending emails is fun again!')
    ->html('<p>See Twig integration for better HTML integration!</p>');

try {
    $mailer->send($email);
    echo 'email sent';
} catch (TransportExceptionInterface $exception) {
    echo 'email sending failed - ' . $exception->getMessage();
}
