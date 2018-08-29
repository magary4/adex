<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

use Adex\Api\Adapter\Slim\DIC;
use Adex\Api\Adapter\Slim\Routes;

// Instantiate the app
$settings = require __DIR__ . '/../configs/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dic = new DIC($app->getContainer());
$dic->bootstrap();

// Register routes
$dic = new Routes($app);
$dic->bootstrap();

// Run app
$app->run();
