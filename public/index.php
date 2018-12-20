<?php
define('APPLICATION_PATH', dirname(dirname(__FILE__)));

if (!file_exists(APPLICATION_PATH.'/vendor/autoload.php')) {
    echo 'framework error' . PHP_EOL;
    die();
}

require_once APPLICATION_PATH . '/vendor/autoload.php';

$app = new Slim\App();
var_dump($app);exit;