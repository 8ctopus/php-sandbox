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
$subject = 'Email subject';
$body = 'Email text body';

$headers = <<<HEADERS
From: webmaster@example.com
Reply-To: webmaster@example.com.
HEADERS;

if (!mail($email, $subject, $body, $headers)) {
    throw new Exception('send email');
}

/*
$server = 'mail.octopuslabs.io';
$pass = '';
$transport = Transport::fromDsn("smtp://{$email}:{$pass}@{$server}:25");
*/

$transport = Transport::fromDsn("sendmail://default");

$mailer = new Mailer($transport);

$email = (new Email())
    ->from($email)
    ->to($email)
    ->subject($subject)
    ->text($body)
    ->html('<p>See Twig integration for better HTML integration!</p>');

$mailer->send($email);

?>
<p> emails sent </p>
<a href="localhost:8025">check mailpit</a>
