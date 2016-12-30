<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 12:05 AM
 */

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
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
        $result = !empty($meta) ? ['data' => $data, 'meta' => $meta] :['data' => $data] ;
        return $response->withJson($result);
    }

}