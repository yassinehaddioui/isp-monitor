<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 12:06 AM
 */

namespace IspMonitor\Controllers;

use IspMonitor\Models\SpeedTest;
use Slim\Http\Request;
use Slim\Http\Response;




class SpeedTestController extends BaseController
{
    public function getSpeed(Request $request, Response $response, $args){
        $streamSpeed = new \IspMonitor\Models\StreamSpeed();
        $streamTest = new SpeedTest($streamSpeed, $streamSpeed);
        return $response->withJson($streamTest);
    }
}