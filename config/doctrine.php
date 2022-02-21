<?php

require_once 'config.php';

const DB_PARAMS = array(
        'driver'   => 'driver',
        'user'     => 'user',
        'password' => 'password',
        'dbname'   => 'dbname',
);

if (defined('APPS')) {
    $apps = array_map(
            function ($appName) {
                return dirname(__DIR__)."/$appName/models";
            },
            constant('APPS')
    );
}
define('MODELS_PATHS', $apps ?? []);
unset($apps);