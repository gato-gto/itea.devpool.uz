<?php

require_once 'vendor/autoload.php';
require_once "config/doctrine.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

function entityManager()
{
    $config = Setup::createAnnotationMetadataConfiguration(MODELS_PATHS, DEBUG, null, null, false);
    return EntityManager::create(DB_PARAMS, $config);
}

$GLOBALS['entityManager'] = entityManager();