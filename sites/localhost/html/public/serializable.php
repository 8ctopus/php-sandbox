<?php

declare(strict_types=1);

namespace App;

use Stringable;

$autoLoad = '../vendor/autoload.php';

if (!file_exists($autoLoad)) {
    header('Content-type: text');

    echo <<<'TXT'
    please run and refresh the page:

    docker exec -it sandbox zsh
    cd localhost/html
    composer install
    TXT;

    exit;
}

// include composer dependencies
require_once $autoLoad;

// create whoops object
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

class User implements Stringable
{
    private string $firstName;
    private string $lastName;

    public function setFirstName(string $firstName) : self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName) : self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function __serialize() : array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    public function __unserialize(array $data) : void
    {
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
    }

    public function __toString(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}

session_start();

if (array_key_exists('user', $_SESSION)) {
    // user object is automatically unserialized
    $user = $_SESSION['user'];

    echo $user;
} else {
    echo 'no user, create user in session. Refresh the page to view the user.';

    $user = (new User())
        ->setFirstName('John')
        ->setLastName('Doe');

    // user is automatically serialized
    $_SESSION['user'] = $user;
}
