<?php
// Routes

use IspMonitor\Controllers\SpeedTestController;
use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/speedtest', function (Request $request, Response $response) use ($app) {
    $controller = new SpeedTestController($app->getContainer());
    return $controller->getSpeed($request, $response);
});

$app->get('/speedtest/logs', function (Request $request, Response $response) use ($app) {
    $controller = new SpeedTestController($app->getContainer());
    return $controller->getResults($request, $response);
});


$app->get('/', function (Request $request, Response $response, $args) use ($app) {
    $service = $app->getContainer()->get('renderer');
    $controller = new \IspMonitor\Controllers\IndexController($service);
    return $controller->getIndex($request, $response, $args);
});