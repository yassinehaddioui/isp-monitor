<?php
// Application middleware
$checkProxyHeaders = true;
$trustedProxies = ['10.0.0.1', '10.0.0.2', 'isp-monitor-webserver', '172.17.0.5', '172.17.0.1'];
$app->add(new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));
$app->add(new \IspMonitor\Middlewares\Authentication($app->getContainer()->get('authService')));
