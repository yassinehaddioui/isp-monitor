<?php

namespace IspMonitor\Services;

use Slim;

class ErrorHandlingService
{
    function __invoke($request, Slim\Http\Response $response, \Exception $exception)
    {
        $data = [
            'error' => true,
            'message' => $exception->getMessage(),
            'statusCode' => $exception->getCode()
        ];
        return (new Slim\Http\Response())->withStatus($exception->getCode())
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($data));
    }
}