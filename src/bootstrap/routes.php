<?php
// Routes

$app->get('/speedtest', '\IspMonitor\Controllers\SpeedTestController:getSpeed');

$app->get('/', '\IspMonitor\Controllers\IndexController:getIndex');