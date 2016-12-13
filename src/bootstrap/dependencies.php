<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $serviceProvider = new \IspMonitor\Providers\ServiceProvider($c);
    return $serviceProvider->getRenderer();
};

// monolog
$container['logger'] = function ($c) {
    $serviceProvider = new \IspMonitor\Providers\ServiceProvider($c);
    return $serviceProvider->getLogger();
};

// Speed Test Service
$container['speedTestService'] = function ($c) {
    $serviceProvider = new \IspMonitor\Providers\ServiceProvider($c);
    return $serviceProvider->getSpeedTestService();
};

$container['authService'] = function ($c) {
    $serviceProvider = new \IspMonitor\Providers\ServiceProvider($c);
    return $serviceProvider->getAuthService();
};

$container['errorHandler'] = function ($c) {
    $serviceProvider = new \IspMonitor\Providers\ServiceProvider($c);
    return $serviceProvider->getErrorHandler();
};