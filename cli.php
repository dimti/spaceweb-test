#!/usr/bin/php
<?php

use Dimti\SpaceWebTest\Domains;
use Dimti\SpaceWebTest\Exceptions\SpaceWebTestException;
use Dimti\SpaceWebTest\NotAuthorized;

require 'vendor/autoload.php';

const BASE_PATH = __DIR__;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

if ($argc != 2) {
    echo PHP_EOL;
    echo "Usage: ./cli.php {domain}" . PHP_EOL;
    echo "Example: ./cli.php dimti-a1.ru";
    echo PHP_EOL;

    exit(1);
}

$domain = filter_var($argv[1], FILTER_VALIDATE_DOMAIN);

if (!$domain) {
    throw new SpaceWebTestException(sprintf(
        'Your argument not a domain: %s',
        $domain
    ));
}

$notAuthorized = new NotAuthorized();

$notAuthorized->getToken(getenv('LOGIN'), getenv('PASS'), getenv('PERSISTENT_SAVE_TOKEN'));

$domains = new Domains();

if ($domains->move($domain) == 1) {
    echo "Domain successfully added";
}
