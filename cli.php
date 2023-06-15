<?php

use Dimti\SpaceWebTest\NotAuthorized;

require 'vendor/autoload.php';

const BASE_PATH = __DIR__;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$notAuthorized = new NotAuthorized();

$notAuthorized->getToken(getenv('LOGIN'), getenv('PASS'), getenv('PERSISTENT_SAVE_TOKEN'));
