<?php
define('APPLICATION_PATH', dirname(dirname(__FILE__)));

if (!file_exists(APPLICATION_PATH.'/vendor/autoload.php')) {
    echo 'framework error' . PHP_EOL;
    die();
}


require_once APPLICATION_PATH . '/vendor/autoload.php';

//$app = new Slim\App();
//
//$app->get('/', function ($request, $response, $args) {
//    $response->write("Welcome to Slim!");
//    return $response;
//});
//
//$app->get('/hello[/{name}]', function ($request, $response, $args) {
//    $response->write("Hello, " . $args['name']);
//    return $response;
//})->setArgument('name', 'World!');
//
//$app->run();

$p = new \PhpOffice\PhpWord\PhpWord();
$path =  APPLICATION_PATH.'/public/index.doc';
$res = $p->loadTemplate($path);
$p->save(APPLICATION_PATH.'/public/index1.doc', 'Word2007',1);
