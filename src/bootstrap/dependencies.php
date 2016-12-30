<?php
// DIC configuration

use IspMonitor\Providers\ServiceProvider;

$container = $app->getContainer();
$container['serviceProvider'] = new ServiceProvider($container);
$container['serviceProvider']->initializeContainer();