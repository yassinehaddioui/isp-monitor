<?php
// Routes

use IspMonitor\Controllers\SpeedTestController;
use Slim\Http\Request;
use Slim\Http\Response;



$app->get('/cache/{key}', function (Request $request, Response $response, $args) use ($app) {
    $service = $app->getContainer()->get('cachingService');
    return (new \IspMonitor\Controllers\CacheController($service))->getData($request, $response, $args);
});

$app->post('/cache/{key}', function (Request $request, Response $response, $args) use ($app) {
    $service = $app->getContainer()->get('cachingService');
    return (new \IspMonitor\Controllers\CacheController($service))->setData($request, $response, $args);
});


$app->get('/', function (Request $request, Response $response, $args) use ($app) {
    $service = $app->getContainer()->get('renderer');
    $controller = new \IspMonitor\Controllers\IndexController($service);
    return $controller->getIndex($request, $response, $args);
});

$app->get('/auth-check', function (Request $request, Response $response, $args) use ($app) {
    return (new Response(200))->withJson(['Authorized' => true]);
});

$app->get('/test', function (Request $request, Response $response, $args) use ($app) {
    $testController = new \IspMonitor\Controllers\TestController($app->getContainer());
    return $testController->getTest($request, $response, $args);
});

$app->post('/api/1.0/reservation', function (Request $request, Response $response, $args) use ($app) {
    $testController = new \IspMonitor\Controllers\TestController($app->getContainer());
    return $testController->getTest($request, $response, $args);
});