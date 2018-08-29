<?php

// This file is required by Doctrine CLI

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;
use Adex\Api\Adapter\Slim\DIC;

/** @var Container $container */
$container = new Container(require __DIR__ . '/configs/settings.php');

$dic = new DIC($container);
$dic->bootstrapDoctrine();

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($container[EntityManager::class])
);
