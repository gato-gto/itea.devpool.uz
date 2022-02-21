<?php

require_once 'config.php';

const DB_PARAMS = array(
    'driver' => 'pdo_mysql',
    'user' => 'itea_doctrine',
    'password' => '280SQiZVsAPw7e6o',
    'dbname' => 'itea_doctrine',
    'host' => '10.32.3.20',
);

if (defined('APPS')) {
    $apps = array_map(
        function ($appName) {
            return dirname(__DIR__) . "/$appName/models";
        },
        constant('APPS')
    );
}
define('MODELS_PATHS', $apps ?? []);
unset($apps);