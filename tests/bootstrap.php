<?php

require_once __DIR__ . '/../vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("ProductDiscounter\\Tests\\", __DIR__, true);
$classLoader->register();

use Slim\App;
use Slim\Container;

$container = new Container();
require_once __DIR__ . '/../rules/enabled.php';

$settings = $container->get('settings');
$settings->replace([
    'displayErrorDetails' => false,
    'debug' => false
]);
$app = new App($container);
