<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 12:06 AM
 */

namespace IspMonitor\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use IspMonitor\Interfaces\SpeedTestService;



class SpeedTestController extends BaseController
{


    public function getSpeed(Request $request, Response $response, $args){
        /** @var SpeedTestService $service */
        $service = $this->ci->get('speedTestService');
        $data = $service->speedTest();
        return $response->withJson(['data'  =>  $data]);
    }
}