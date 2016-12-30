<?php

namespace IspMonitor\Services;

use IspMonitor\Models\ExceptionResponse;
use Slim;
use Slim\Http\Response;

class ErrorHandlingService implements \IspMonitor\Interfaces\ErrorHandlingService
{
    const DEFAULT_EXCEPTION_STATUS_CODE = 500;
    /**
     * @param $request
     * @param Slim\Http\Response $response
     * @param \Exception $exception
     * @return Response
     */
    function __invoke($request, Slim\Http\Response $response, \Exception $exception)
    {
        $statusCode = $exception->getCode() >= 100 ? $exception->getCode() : static::DEFAULT_EXCEPTION_STATUS_CODE;
        $data = new ExceptionResponse($statusCode, $exception->getMessage());
        return (new Response())->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withJson($data);
    }
}