<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/26/16
 * Time: 7:00 PM
 */

namespace IspMonitor\Interfaces;

use Slim\Http\Response;


interface ErrorHandlingService
{
    /**
     * @param $request
     * @param Response $response
     * @param \Exception $exception
     * @return Response
     */
    function __invoke($request, Response $response, \Exception $exception);
}