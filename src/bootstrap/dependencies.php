<?php
// DIC configuration

use IspMonitor\Providers\ServiceProvider;
use IspMonitor\Providers\DependencyInjector;

$container = $app->getContainer();
$container['serviceProvider'] = new ServiceProvider($container->get('settings'));
$container = DependencyInjector::initializeContainer($container);