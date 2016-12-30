<?php
// Application middleware

$app->add(new \IspMonitor\Middlewares\Authentication($app->getContainer()->get('authService')));
