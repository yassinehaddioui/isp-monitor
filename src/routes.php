<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    $controller = new \IspMonitor\Controllers\SpeedTestController();
    return $controller->getSpeed($request, $response, $args);
});
