<?php

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
use IspMonitor\Utilities\Environment;
use Slim\Http\Response;

class BaseController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * @return BaseController
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param Response $response
     * @param mixed $data
     * @param array $meta
     * @return Response
     */

    protected function jsonDataResponse(Response $response, $data, $meta = [])
    {
        if (!empty($meta)) {
            $meta['appVersion'] = Environment::getPackageVersion();
        }
        $result = !empty($meta) ? ['data' => $data, 'meta' => $meta] : ['data' => $data];
        return $response->withJson($result);
    }

}