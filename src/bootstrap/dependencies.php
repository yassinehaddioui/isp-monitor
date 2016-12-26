<?php
// DIC configuration

use IspMonitor\Providers\ServiceProvider;

$container = $app->getContainer();
$serviceProvider = new ServiceProvider($container);
$serviceProvider->initializeContainer();