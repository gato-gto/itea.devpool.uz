<?php

require_once 'config/doctrine.php';
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$config = Setup::createAnnotationMetadataConfiguration(MODELS_PATHS, DEBUG, null, null, false);

$objects = EntityManager::create(DB_PARAMS, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($objects);
